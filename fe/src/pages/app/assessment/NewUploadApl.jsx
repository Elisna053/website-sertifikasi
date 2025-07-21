// src/pages/user/assessment/NewUploadApl.jsx
import { Button } from '@/components/ui/button';
import { useParams, useNavigate } from "react-router-dom";
import { FiArrowLeft } from 'react-icons/fi';
import React, { useState, useEffect } from "react";
import { Spinner } from "@/components/ui/spinner";
import { toast } from "react-hot-toast";
import UnitDropzone from './UnitDropzone';

const NewUploadApl = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  const [schema, setSchema] = useState(null);
  const [berkasAplId, setBerkasAplId] = useState(null);
  const [loading, setLoading] = useState(true);
  const [errors, setErrors] = useState({}); 
  const [uploadedFiles, setUploadedFiles] = useState({});
  const [additionalFile, setAdditionalFile] = useState(null);
  const [additionalFileError, setAdditionalFileError] = useState('');


  const API_URL = import.meta.env.VITE_API_URL || window.ENV_API_URL || "http://localhost:8000/api";

  useEffect(() => {
    const html = document.documentElement;
    const body = document.body;
    const root = document.getElementById("root");

    const prevHtmlStyle = html.style.cssText;
    const prevBodyStyle = body.style.cssText;
    const prevRootStyle = root?.style.cssText;

    html.style.height = "100%";
    html.style.overflow = "hidden";
    body.style.height = "100%";
    body.style.overflow = "hidden";
    if (root) {
      root.style.height = "100%";
      root.style.overflow = "hidden";
    }

    return () => {
      html.style.cssText = prevHtmlStyle;
      body.style.cssText = prevBodyStyle;
      if (root) root.style.cssText = prevRootStyle || "";
    };
  }, []);


  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const token = localStorage.getItem('token');
        const response = await fetch(`${API_URL}/get_unit_by_id_ass/${id}`, {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        });
  
        const result = await response.json();
  
        if (result.success && result.data) {
          const schema = result.data.schema;
          const berkasApl = result.data.berkas_apl;
          const aplId = result.data.berkas_apl.id;
  
          const unitFiles = {};
          let additional = null;
  
          if (berkasApl && Array.isArray(berkasApl)) {
            berkasApl.forEach((file) => {
              if (file.type === 'additional') {
                additional = {
                  id: file.id,
                  name: file.file,
                  path: `${API_URL}/${file.file_path}`,
                  existing: true
                };
              } else {
                unitFiles[file.schema_unit_id] = {
                  id: file.id,
                  name: file.file,
                  path: `${API_URL}/${file.file_path}`,
                  existing: true
                };
              }
            });
          }
  
          setBerkasAplId(aplId);
          setSchema(schema);
          setUploadedFiles(unitFiles);
          setAdditionalFile(additional);
        } else {
          toast.error(result.message || "Gagal mendapatkan data");
        }
      } catch (err) {
        toast.error("Terjadi kesalahan saat mengambil data");
      } finally {
        setLoading(false);
      }
    };
  
    fetchData();
  }, [API_URL, id]);
  

  const handleBack = () => {
    navigate("/app/assessee");
  };

  const handleFileDrop = (unitId) => (acceptedFiles) => {
    if (acceptedFiles && acceptedFiles.length > 0) {
      setUploadedFiles((prev) => ({
        ...prev,
        [unitId]: acceptedFiles[0]
      }));
    }
  };

  const handleClearFile = (unitId) => {
    setUploadedFiles((prev) => {
      const updated = { ...prev };
      delete updated[unitId];
      return updated;
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const newErrors = {};
  
    schema.units.forEach((unit) => {
      const file = uploadedFiles[unit.id];
      if (!file) {
        newErrors[unit.id] = "Berkas wajib diunggah untuk unit ini";
      }
    });
  
    if (Object.keys(newErrors).length > 0) {
      setErrors(newErrors);
      return;
    }
  
    setLoading(true);
  
    try {
      const token = localStorage.getItem("token");
  
      for (const unit of schema.units) {
        const file = uploadedFiles[unit.id];
  
        if (!file || file.existing) continue;
  
        const formData = new FormData();

        if (file.id) {
          formData.append("id", file.id);
        }

        formData.append("assessee_id", id);
        formData.append("schema_id", schema.id);
        formData.append("schema_unit_id", unit.id);
        formData.append("file", file); // File instance
  
        const response = await fetch(`${API_URL}/apl_upload`, {
          method: "POST",
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json"
          },
          body: formData,
        });
  
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || "Gagal upload");
      }
  
      // Upload berkas tambahan hanya jika file baru
      if (additionalFile && !additionalFile.existing) {
        const formData = new FormData();
        formData.append("assessee_id", id);
        formData.append("schema_id", schema.id);
        formData.append("type", "additional");
        formData.append("file", additionalFile);
  
        const response = await fetch(`${API_URL}/apl_upload`, {
          method: "POST",
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
          },
          body: formData,
        });
  
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || "Gagal upload APL lainnya");
      }
  
      toast.success("Semua berkas berhasil diunggah");
      navigate(-1);
    } catch (err) {
      toast.error(err.message || "Terjadi kesalahan saat upload");
    } finally {
      setLoading(false);
    }
  };
  

  if (loading && !schema) {
    return (
      <div className="flex justify-center items-center min-h-[200px]">
        <Spinner size="lg" />
      </div>
    );
  }

  
  return (
    <div className="w-full max-w-screen-md mx-auto p-4 overflow-x-hidden">
      <div className="flex items-center mb-6">
        <Button variant="outline" onClick={handleBack} className="mr-4">
          <FiArrowLeft className="mr-2" /> Kembali
        </Button>
        <h1 className="text-2xl font-bold">Lengkapi Berkas APL</h1>
      </div>
      <div className="bg-white p-4 rounded-lg shadow-sm mb-6">
      <h2 className="text-lg font-semibold mb-2">
        Schema pilihan: {schema?.name}
      </h2>
        </div>
      


      <div>
        <form
          onSubmit={handleSubmit}
          className="space-y-6 bg-white p-4 rounded-lg shadow-sm mb-6"
        >
          {schema?.units?.map((unit) => (
            <UnitDropzone
              key={unit.id}
              unit={unit}
              uploadedFile={uploadedFiles[unit.id]}
              onDrop={handleFileDrop(unit.id)}
              onClear={() => handleClearFile(unit.id)}
              error={errors?.[unit.id]}
            />
          ))}

          <UnitDropzone
            unit={{ id: 'additional_apl', name: 'Berkas APL Lainnya (Opsional)' }}
            uploadedFile={additionalFile}
            onDrop={(files) => setAdditionalFile(files[0])}
            onClear={() => setAdditionalFile(null)}
            error={additionalFileError}
          />


          
          <div className="flex justify-end gap-3 pt-3">
            <Button type="submit" disabled={loading}>
              {loading ? "Menyimpan..." : "Simpan"}
            </Button>
          </div>
        </form>
        </div>
        </div>

  );
};

export default NewUploadApl;


