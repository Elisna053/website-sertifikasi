import React, { useState } from "react";
import { NavLink } from "react-router-dom";
import logoLSP from "@/assets/Icon/logoLSP.png"; // Correct import statement

export default function Navbar() {
  const [navbarOpen, setNavbarOpen] = useState(false);
  return (
    <>
      <nav className="fixed top-0 left-0 right-0 z-50 flex flex-wrap items-center justify-between md:px-12 lg:px-24 py-4 bg-[#00002F] text-white backdrop-blur-lg shadow-md">
        <div className="container px-4 mx-auto flex flex-wrap items-center justify-between">
          <div className="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start">
            <NavLink to="/" className="group">
              <div className="flex items-center w-full h-[50px]">
                {/* Use the imported logoLSP variable */}
                <img src={logoLSP} alt="LSP Logo" className="h-[100px]" />
              </div>
            </NavLink>
            <button
              className="text-white cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none"
              type="button"
              onClick={() => setNavbarOpen(!navbarOpen)}
            >
              <i>
                <svg fill="#FFFFFF" width="40px" height="40px" viewBox="0 0 32 32" enableBackground="new 0 0 32 32" id="Glyph" version="1.1" xmlSpace="preserve" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink">
                  <path d="M26,16c0,1.104-0.896,2-2,2H8c-1.104,0-2-0.896-2-2s0.896-2,2-2h16C25.104,14,26,14.896,26,16z" id="XMLID_314_" />
                  <path d="M26,8c0,1.104-0.896,2-2,2H8c-1.104,0-2-0.896-2-2s0.896-2,2-2h16C25.104,6,26,6.896,26,8z" id="XMLID_315_" />
                  <path d="M26,24c0,1.104-0.896,2-2,2H8c-1.104,0-2-0.896-2-2s0.896-2,2-2h16C25.104,22,26,22.896,26,24z" id="XMLID_316_" />
                </svg>
              </i>
            </button>
          </div>
          <div className={"lg:flex flex-wrap items-center" + (navbarOpen ? "flex" : " hidden")} id="example-navbar-danger">
            <ul className="flex flex-col lg:flex-row list-none lg:ml-auto">
            <NavLink
              to="/"
              className={({ isActive }) =>
                `px-3 py-2 inline-block lg:flex items-center text-md font-semibold leading-snug ${
                  isActive ? 'underline text-yellow-300' : ''
                }`
              }>
              <div className="ml-2 mt-1 flex items-center hover:underline">Beranda</div>
            </NavLink>
            <NavLink
              to="/Partnership"
              className={({ isActive }) =>
                `px-3 py-2 inline-block lg:flex items-center text-md font-semibold leading-snug ${
                  isActive ? 'underline text-yellow-300' : ''
                }`
              }
            >
              <div className="ml-2 mt-1 flex items-center hover:underline">Partnership</div>
            </NavLink>

            <NavLink
              to="/Tentang"
              className={({ isActive }) =>
                `px-3 py-2 inline-block lg:flex items-center text-md font-semibold leading-snug`
              }
            >
              {({ isActive }) => (
                <div className={`ml-2 mt-1 flex items-center ${isActive ? 'underline text-yellow-300' : 'lg:hover:underline'}`}>
                  Tentang
                </div>
              )}
            </NavLink>

            <NavLink
              to="/Skema"
              className={({ isActive }) =>
                `px-3 py-2 inline-block lg:flex items-center text-md font-semibold leading-snug`
              }
            >
              {({ isActive }) => (
                <div className={`ml-2 mt-1 flex items-center ${isActive ? 'underline text-yellow-300' : 'lg:hover:underline'}`}>
                  Skema
                </div>
              )}
            </NavLink>

            <NavLink
              to="/Tuks"
              className={({ isActive }) =>
                `px-3 py-2 inline-block lg:flex items-center text-md font-semibold leading-snug`
              }
            >
              {({ isActive }) => (
                <div className={`ml-2 mt-1 flex items-center ${isActive ? 'underline text-yellow-300' : 'lg:hover:underline'}`}>
                  TUKS
                </div>
              )}
            </NavLink>

            <NavLink
              to="/Galeri"
              className={({ isActive }) =>
                `px-3 py-2 inline-block lg:flex items-center text-md font-semibold leading-snug`
              }
            >
              {({ isActive }) => (
                <div className={`ml-2 mt-1 flex items-center ${isActive ? 'underline text-yellow-300' : 'lg:hover:underline'}`}>
                  Galeri
                </div>
              )}
            </NavLink>

            <NavLink
              to="/Berita"
              className={({ isActive }) =>
                `px-3 py-2 inline-block lg:flex items-center text-md font-semibold leading-snug`
              }
            >
              {({ isActive }) => (
                <div className={`ml-2 mt-1 flex items-center ${isActive ? 'underline text-yellow-300' : 'lg:hover:underline'}`}>
                  Berita
                </div>
              )}
            </NavLink>

            <NavLink
              to="/Kontak"
              className={({ isActive }) =>
                `px-3 py-2 inline-block lg:flex items-center text-md font-semibold leading-snug`
              }
            >
              {({ isActive }) => (
                <div className={`ml-2 mt-1 flex items-center ${isActive ? 'underline text-yellow-300' : 'lg:hover:underline'}`}>
                  Kontak
                </div>
              )}
            </NavLink>

            <NavLink
              to="/auth/login"
              className={({ isActive }) =>
                `px-3 py-2 inline-block lg:flex items-center text-md font-semibold leading-snug`
              }
            >
              {({ isActive }) => (
                <div className={`ml-2 mt-1 flex items-center ${isActive ? 'underline text-yellow-300' : 'lg:hover:underline'}`}>
                  Login
                </div>
              )}
            </NavLink>

              
            </ul>
          </div>
        </div>
      </nav>
    </>
  );
}
