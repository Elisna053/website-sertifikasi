import React, { useEffect, useState } from "react";

export const StrukturOrganisasi = () => {
  const [struktur, setStruktur] = useState([]);
  const [loading, setLoading] = useState(false);  
  const [error, setError] = useState(null);       

  const API_URL = import.meta.env.VITE_API_URL || window.ENV_API_URL || "http://localhost:8000/api";
  const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || "http://localhost:8000";

  const fetchGalleries = async () => {
    try {
      setLoading(true);
      const token = localStorage.getItem("token");
      const response = await fetch(`${API_URL}/struktur-references`, {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json"
        }
      });

      if (!response.ok) throw new Error(`Error: ${response.status}`);

      const result = await response.json();
      if (result.success && result.data) {
        setStruktur(result.data);
      } else {
        setError(result.message || "Gagal mendapatkan data");
      }
    } catch (err) {
      console.error("Error fetching data:", err);
      setError("Terjadi kesalahan saat mengambil data");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchGalleries();
  }, [API_URL]);

  if (loading) return <div className="p-6 text-center">Loading struktur...</div>;
  if (error) return <div className="p-6 text-red-500 text-center">{error}</div>;
  if (!struktur.length) return <div className="p-6 text-center">Tidak ada data struktur.</div>;

  return (
    <div className="grid gap-6 p-6">
      {/* Row 1: Leader */}
      <div className="flex justify-center">
        <div className="flex flex-col items-center text-center">
          <img
            src={`${API_BASE_URL}/${struktur[0].image_url}`}
            alt={struktur[0].struktur_name}
            className="w-20 h-20 rounded-full object-cover border-2 border-gray-300"
          />
          <h3 className="mt-4 text-sm font-semibold text-gray-800">{struktur[0].struktur_name}</h3>
          <p className="text-xs text-gray-500 mt-1 whitespace-pre-line">{struktur[0].struktur_posis}</p>
        </div>
      </div>

      {/* Other Members */}
      <div className="grid grid-cols-2 md:grid-cols-3 gap-6">
        {struktur.slice(1).map((member, index) => (
          <div key={member.id || index} className="flex flex-col items-center text-center">
            <img
              src={`${API_BASE_URL}/${member.image_url}`}
              alt={member.struktur_name}
              className="w-20 h-20 rounded-full object-cover border-2 border-gray-300"
            />
            <h3 className="mt-4 text-sm font-semibold text-gray-800">{member.struktur_name}</h3>
            <p className="text-xs text-gray-500 mt-1 whitespace-pre-line">{member.struktur_posis}</p>
          </div>
        ))}
      </div>
    </div>
  );
};

export default StrukturOrganisasi;
