// components/UnitDropzone.jsx
import React from 'react';
import { useDropzone } from 'react-dropzone';
import { FiUpload, FiX } from 'react-icons/fi';

const UnitDropzone = ({ unit, onDrop, uploadedFile, onClear, error }) => {
  const { getRootProps, getInputProps } = useDropzone({
    onDrop,
    accept: {
      'application/pdf': ['.pdf'],
      'image/*': ['.jpg', '.jpeg', '.png', '.gif']
    },
    maxSize: 5 * 1024 * 1024,
    multiple: false
  });

  return (

    <>
 <label className="block text-sm font-medium text-gray-700 mb-1">
        {unit.name} <span className="text-red-500">*</span>
      </label>

      <div
        {...getRootProps()}
        className={`
          border-2 border-dashed rounded-lg p-6 cursor-pointer text-center
          transition-colors hover:border-gray-400
          ${uploadedFile
            ? 'border-green-500 bg-green-50'
            : error
            ? 'border-red-500 bg-red-50'
            : 'border-gray-300 bg-gray-50'}
        `}
      >
        <input {...getInputProps()} />
        {uploadedFile ? (
          <div className="relative text-left">
    <a
      href={uploadedFile.path || '#'}
      target="_blank"
      rel="noopener noreferrer"
      className="text-sm font-medium text-green-700 underline truncate block"
    >
      📄 {uploadedFile.name}
    </a>
    <button
      type="button"
      onClick={onClear}
      className="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600"
    >
      <FiX className="h-4 w-4" />
    </button>
  </div>
        ) : (
          <div className="space-y-2">
            <FiUpload className="mx-auto h-12 w-12 text-gray-400" />
            <p className="text-gray-600">Klik atau seret berkas ke area ini untuk mengunggah</p>
            <p className="text-xs text-gray-500">Format: PDF, JPG, PNG, GIF (Max 5MB)</p>
          </div>
        )}
      </div>

      {error && <p className="text-red-500 text-sm">{error}</p>}
    </>

  );
};

export default UnitDropzone;
