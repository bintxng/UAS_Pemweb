function displaySuccess() {
  var successPopup = document.getElementById('successPopup');
  successPopup.style.display = 'block';
  setTimeout(function() {
    successPopup.style.display = 'none';
}, 5000);  // Menyembunyikan pop-up berhasil setelah 5 detik

}function displayError(message) {
  var errorPopup = document.getElementById('errorPopup');
  var errorMessage = document.getElementById('errorMessage');
  
  errorMessage.innerText = message;
  errorPopup.style.display = 'block';

  setTimeout(function() {
      errorPopup.style.display = 'none';
  }, 5000);  // Menyembunyikan pesan error setelah 5 detik
}

function clearForm() {
  // Gantilah dengan ID formulir Anda yang sebenarnya
  document.getElementById('formulirPendaftaran').reset();
}

function validateForm() {
    var full_name = document.getElementById('full_name').value;
    var email = document.getElementById('email').value;
    var gender = document.getElementById('gender').value;
    var birthdate = document.getElementById('birthdate').value;
    var ktp_address = document.getElementById('ktp_address').value;
    var dom_address = document.getElementById('dom_address').value;
    var type = document.getElementById('type').value;
    var terms = document.getElementById('terms').checked;

    if (full_name.trim() === '') {
        displayError('Nama lengkap harus diisi.');
        return false;
      }
    if (email.trim() === ''){
      displayError('Email harus diisi');
      return false;
    }
    if (gender === 'default') {
      displayError('Pilih jenis kelamin');
      return false;
    }
 
    if (birthdate.trim() === ''){
      displayError('Tanggal lahir harus diisi');
      return false;
    }
    if (ktp_address.trim() === ''){
      displayError('Alamat KTP harus diisi');
      return false;
    }
    if (dom_address.trim() === ''){
      displayError('Alamat Domisili harus diisi');
      return false;
    }    
    if (type === 'default') {
      displayError('Pilih tipe rekening');
      return false;
    }  
    if (!terms) {
      displayError('Anda harus menyetujui syarat dan ketentuan.');
      return false;
    }

    fetch('form-handler.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams(new FormData(document.getElementById('formulirPendaftaran'))),
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          displaySuccess();
          clearForm();          
      } else {
          displayError(data.error || 'Terjadi kesalahan saat menyimpan data.');
      }
  })
  .catch(error => console.error('Error:', error));

  return false; // Hindari submit form secara langsung
}


    

    
