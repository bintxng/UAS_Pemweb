<?php
class FormValidator {
    public function isValidDate($date) {
        // Implementasi validasi tanggal
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
    public function validateForm($formData) {
        $errors = [];

        // Logika validasi formulir
        if (empty($formData['full_name'])) {
            $errors['full_name'] = 'Nama lengkap harus diisi.';
        }

        if (empty($formData['email']) || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid.';
        }
        
        if (empty($formData['gender'])) {
            $errors['gender'] = 'Pilih jenis kelamin.';
        }

        if (empty($formData['birthdate']) || !$this->isValidDate($formData['birthdate'])) {
            $errors['birthdate'] = 'Tanggal lahir tidak valid.';
        }

        if (empty($formData['ktp_address'])) {
            $errors['ktp_address'] = 'Alamat KTP harus diisi.';
        }

        if (empty($formData['dom_address'])) {
            $errors['dom_address'] = 'Alamat domisili harus diisi.';
        }

        if (empty($formData['type'])) {
            $errors['type'] = 'Pilih tipe rekening.';
        }

        if (empty($formData['terms'])) {
            $errors['terms'] = 'Anda harus menyetujui syarat dan ketentuan.';
        }


        return $errors;
    }
}

