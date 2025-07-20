import React, { useState, useEffect } from "react";
import { FiPlus, FiEdit2, FiTrash2, FiSearch } from "react-icons/fi";
import { Button } from "@/components/ui/button";
import {
  Table,
  TableHeader,
  TableBody,
  TableHead,
  TableRow,
  TableCell
} from "@/components/ui/table";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
  DialogFooter
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { toast } from "react-hot-toast";
import { Spinner } from "@/components/ui/spinner";
import { useNavigate } from "react-router-dom";
import { FileIcon } from "lucide-react";

const MetodeList = () => {
  const [metodes, setMetodes] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [searchQuery, setSearchQuery] = useState("");
  const [showAddModal, setShowAddModal] = useState(false);
  const [showEditModal, setShowEditModal] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [currentMetode, setCurrentMetode] = useState(null);
  const [formData, setFormData] = useState({ nama_metode: "", file: null, id: null });
  const [formErrors, setFormErrors] = useState({});
  const [actionLoading, setActionLoading] = useState(false);
  const [filePreview, setFilePreview] = useState(null);


  const API_URL = import.meta.env.VITE_API_URL || window.ENV_API_URL || "http://localhost:8000/api";
  const navigate = useNavigate();

  const fetchMetodes = async () => {
    try {
      setLoading(true);
      const token = localStorage.getItem('token');
      const response = await fetch(`${API_URL}/metode_sertifikasi_references`, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });
      const result = await response.json();
      if (result.success && result.data) {
        setMetodes(result.data);
      } else {
        setError(result.message || "Gagal mendapatkan data metode");
      }
    } catch (err) {
      setError("Terjadi kesalahan saat mengambil data metode");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchMetodes();
  }, [API_URL]);

  const filteredMetodes = metodes.filter(item => 
    item.nama_metode?.toLowerCase().includes(searchQuery.toLowerCase())
  );

  const handleAdd = () => {
    setFormData({
      nama_metode: "",
      file: null,
      id: null
    });
    setFormErrors({});
    setShowAddModal(true);
  };

  const handleEdit = (metode) => {
    setCurrentMetode(metode);
    setFormData({
      id: metode.id,
      nama_metode: metode.nama_metode,
      file: null 
    });
  
    if (metode.file_path) {
      setFilePreview({
        url: metode.file_path,
        type: metode.file_path.endsWith(".pdf")
          ? "application/pdf"
          : metode.file_path.match(/\.(jpg|jpeg|png|gif|svg)$/i)
          ? "image/*"
          : "other",
      });
    } else {
      setFilePreview(null);
    }
  
    setFormErrors({});
    setShowEditModal(true);
  };
  

  const handleDelete = (metode) => {
    setCurrentMetode(metode);
    setShowDeleteModal(true);
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
    if (formErrors[name]) {
      setFormErrors({ ...formErrors, [name]: null });
    }
  };

  useEffect(() => {
    return () => {
      if (filePreview?.url) {
        URL.revokeObjectURL(filePreview.url);
      }
    };
  }, [filePreview]);


  const resetForm = () => {
    setFormData({
      id: null,
      nama_metode: "",
      file: null
    });
    setFormErrors({});
    if (filePreview?.url && filePreview.url.startsWith("blob:")) {
      URL.revokeObjectURL(filePreview.url); 
    }
    setFilePreview(null);
  };
  

  

  const handleSubmitAddOrEdit = async (e) => {
    e.preventDefault();
    const errors = {};
    if (!formData.nama_metode?.trim()) errors.nama_metode = "Nama metode wajib diisi";
    if (!formData.id && !formData.file) errors.file = "File wajib diunggah";
    setFormErrors(errors);
    if (Object.keys(errors).length > 0) return;

    try {
      setActionLoading(true);
      const token = localStorage.getItem('token');
      const payload = new FormData();
      payload.append("nama_metode", formData.nama_metode);
      if (formData.file) payload.append("file", formData.file);
      if (formData.id) payload.append("id", formData.id);

      const response = await fetch(`${API_URL}/metodes`, {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`
        },
        body: payload
      });

      const result = await response.json();
      if (!response.ok) {
        if (result.errors) setFormErrors(result.errors);
        throw new Error(result.message || "Gagal menyimpan data");
      }

      toast.success(`Metode berhasil ${formData.id ? "diperbarui" : "ditambahkan"}`);
      setShowAddModal(false);
      setShowEditModal(false);
      setFormData({ nama_metode: "", file: null, id: null });
      fetchMetodes();
    } catch (err) {
      toast.error(err.message || "Terjadi kesalahan saat menyimpan data");
    } finally {
      setActionLoading(false);
    }
  };

  const handleConfirmDelete = async () => {
    try {
      setActionLoading(true);
      const token = localStorage.getItem('token');
      const response = await fetch(`${API_URL}/metodes/${currentMetode.id}`, {
        method: 'DELETE',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });
      if (!response.ok) {
        const result = await response.json();
        throw new Error(result.message || "Gagal menghapus metode");
      }
      toast.success("Metode berhasil dihapus");
      setShowDeleteModal(false);
      fetchMetodes();
    } catch (err) {
      toast.error(err.message || "Terjadi kesalahan saat menghapus metode");
    } finally {
      setActionLoading(false);
    }
  };

  return (
    <div className="container mx-auto p-4">
      <div className="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 className="text-2xl font-bold">Metode Sertifikasi</h1>
        <div className="flex w-full md:w-auto gap-4">
          <div className="relative flex-grow md:min-w-[300px]">
            <Input
              type="text"
              placeholder="Cari data..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="pl-10"
            />
            <FiSearch className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
          </div>
          <Button onClick={handleAdd} className="flex items-center gap-2">
            <FiPlus /> Tambah
          </Button>
        </div>
      </div>

      {loading ? (
        <div className="flex justify-center items-center h-60">
          <Spinner size="lg" />
        </div>
      ) : error ? (
        <div className="bg-red-100 text-red-700 p-4 rounded-lg">{error}</div>
      ) : (
        <div className="overflow-x-auto rounded-lg border">
          <Table className="bg-white">
            <TableHeader className="bg-gray-100">
              <TableRow>
                <TableHead className="w-[60px] text-center font-bold text-gray-500">No</TableHead>
                <TableHead className="font-bold text-gray-500">Nama Metode</TableHead>
                <TableHead className="w-[120px] text-right font-bold text-gray-500">Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredMetodes.map((metode, index) => (
                <TableRow key={metode.id}>
                  <TableCell className="text-center">{index + 1}</TableCell>
                  <TableCell className="font-medium">{metode.nama_metode}</TableCell>
                  <TableCell className="flex justify-end gap-2">
                    <Button
                      variant="outline"
                      size="sm"
                      onClick={() => handleEdit(metode)}
                      className="flex items-center gap-1"
                    >
                      <FiEdit2 className="h-4 w-4" /> Edit
                    </Button>
                    <Button
                      variant="destructive"
                      size="sm"
                      onClick={() => handleDelete(metode)}
                      className="flex items-center gap-1"
                    >
                      <FiTrash2 className="h-4 w-4" /> Hapus
                    </Button>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </div>
      )}

      {/* Modal Tambah/Edit */}
      <Dialog
          open={showAddModal || showEditModal}
          onOpenChange={(isOpen) => {
            if (!isOpen) {
              setShowAddModal(false);
              setShowEditModal(false);
              resetForm();
            }
          }}
        >
        <DialogContent>
          <DialogHeader>
            <DialogTitle>{formData.id ? "Edit" : "Tambah"} Metode</DialogTitle>
            <DialogDescription>
              {formData.id ? "Perbarui" : "Isi"} data metode sertifikasi.
            </DialogDescription>
          </DialogHeader>
          <form onSubmit={handleSubmitAddOrEdit} className="space-y-4">
          <div className="space-y-2">
            <Label htmlFor="nama_metode">Nama Metode</Label>
            <Input
              id="nama_metode"
              name="nama_metode"
              placeholder="Masukkan nama metode"
              value={formData.nama_metode}
              onChange={handleInputChange}
              className={formErrors.nama_metode ? "border-red-500" : ""}
            />
            {formErrors.nama_metode && (
              <p className="text-sm text-red-500">{formErrors.nama_metode}</p>
            )}
          </div>

          {filePreview && (
            <div className="my-4">
              <Label>Preview File</Label>
              <div className="border rounded p-2 mt-2 bg-gray-50">
                {filePreview.type === "application/pdf" ? (
                  <iframe
                    src={filePreview.url}
                    title="PDF Preview"
                    width="100%"
                    height="200px"
                    className="rounded border"
                  />
                ) : filePreview.type.startsWith("image/") || filePreview.type === "image/*" ? (
                  <img
                    src={filePreview.url}
                    alt="Image Preview"
                    className="max-w-full h-[200px] rounded shadow"
                  />
                ) : (
                  <p className="text-sm text-gray-500">Tidak dapat menampilkan preview untuk file ini.</p>
                )}
              </div>
            </div>
          )}

          <div className="space-y-2">
            <Label htmlFor="file">File Template</Label>
            <Input
              id="file"
              name="file"
              type="file"
              accept=".pdf,.jpg,.jpeg,.png,.gif,.svg"
              onChange={(e) => {
                const file = e.target.files[0];
                setFormData({ ...formData, file });

                if (file) {
                  if (filePreview?.url && filePreview.url.startsWith("blob:")) {
                    URL.revokeObjectURL(filePreview.url);
                  }
                  const url = URL.createObjectURL(file);
                  setFilePreview({ url, type: file.type });
                } else {
                  setFilePreview(null);
                }
              }}
            />
            {formErrors.file && (
              <p className="text-sm text-red-500">{formErrors.file}</p>
            )}
          </div>


            <DialogFooter>
              <Button
                type="button"
                variant="outline"
                onClick={() => {
                  setShowAddModal(false);
                  setShowEditModal(false);
                  resetForm(); 
                }}
                disabled={actionLoading}
              >
                Batal
              </Button>
              <Button type="submit" disabled={actionLoading}>
                {actionLoading ? (<><Spinner className="mr-2 h-4 w-4" /> Menyimpan...</>) : "Simpan"}
              </Button>
            </DialogFooter>
          </form>
        </DialogContent>
      </Dialog>

      {/* Modal Konfirmasi Hapus */}
      <Dialog open={showDeleteModal} onOpenChange={setShowDeleteModal}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Konfirmasi Hapus</DialogTitle>
            <DialogDescription>
              Apakah Anda yakin ingin menghapus metode "{currentMetode?.name}"?
            </DialogDescription>
          </DialogHeader>
          <DialogFooter>
            <Button
              type="button"
              variant="outline"
              onClick={() => setShowDeleteModal(false)}
              disabled={actionLoading}
            >
              Batal
            </Button>
            <Button
              type="button"
              variant="destructive"
              onClick={handleConfirmDelete}
              disabled={actionLoading}
            >
              {actionLoading ? (<><Spinner className="mr-2 h-4 w-4" /> Menghapus...</>) : "Hapus"}
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
    </div>
  );
};

export default MetodeList;
