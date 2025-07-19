import React, { useEffect, useState } from "react";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

export const DataAsesor = () => {
  const [assessor, setAssessor] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const API_URL = import.meta.env.VITE_API_URL || window.ENV_API_URL || "http://localhost:8000/api";
  const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || "http://localhost:8000";

  const fetchGalleries = async () => {
    try {
      setLoading(true);
      const token = localStorage.getItem("token");
      const response = await fetch(`${API_URL}/assessor-references`, {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
        },
      });

      if (!response.ok) throw new Error(`Error: ${response.status}`);

      const result = await response.json();
      if (result.success && result.data) {
        setAssessor(result.data);
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

  if (loading) return <div className="p-6 text-center">Loading data asesor...</div>;
  if (error) return <div className="p-6 text-red-500 text-center">{error}</div>;
  if (!assessor.length) return <div className="p-6 text-center">Tidak ada data.</div>;

  const settings = {
    dots: false,
    infinite: true,
    speed: 500,
    autoplay: true,
    autoplaySpeed: 3000,
    slidesToShow: 4,
    slidesToScroll: 1,
    arrows: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: { slidesToShow: 3 },
      },
      {
        breakpoint: 600,
        settings: { slidesToShow: 1 },
      },
    ],
  };

  return (
    <div className="container mx-auto p-6">
      <style jsx>{`
        .slick-prev,
        .slick-next {
          font-size: 16px;
          font-weight: bold;
          color: white;
          background-color: #06113c;
          border: none;
          border-radius: 50%;
          width: 30px;
          height: 30px;
          display: flex;
          justify-content: center;
          align-items: center;
          z-index: 10;
        }
        .slick-prev:hover,
        .slick-next:hover {
          background-color: #eb8317;
        }
        .slick-slide {
          display: flex;
          justify-content: center;
        }
        .card {
          background-color: white;
          border-radius: 8px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          padding: 40px;
          text-align: center;
          max-width: 220px;
          margin: auto;
        }
        .card img {
          width: 100px;
          height: 100px;
          border-radius: 50%;
          object-fit: cover;
          margin-bottom: 15px;
          border: 2px solid #ccc;
        }
        .card h3 {
          font-size: 16px;
          font-weight: 600;
          color: #333;
          margin: 0;
        }
        .card p {
          font-size: 14px;
          color: #666;
          margin: 5px 0;
        }
      `}</style>

      <h1 className="text-center text-2xl font-bold mb-6">Data Asesor</h1>
      <Slider {...settings}>
        {assessor.map((item, index) => (
          <div key={item.id || index} className="card">
            <img src={`${API_BASE_URL}/${item.image_url}`} alt={item.assessor_name} />
            <h3>{item.assessor_name}</h3>
            <p>{item.assessor_posis}</p>
            <p className="noreg">{item.assessor_posis}</p>
          </div>
        ))}
      </Slider>
    </div>
  );
};

export default DataAsesor;
