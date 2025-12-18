CREATE TABLE mahasiswa (
    nim VARCHAR(20) PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    tanggal_lahir DATE NOT NULL
);

INSERT INTO mahasiswa (nim, nama_lengkap, no_hp, tanggal_lahir) VALUES
('TI102132', 'Nuris Akbar', '089699935552', '2007-09-02'),
('TI102133', 'M Hafidz Muzaki', '089699935553', '2007-09-02'),
('TI102134', 'Wahyu Safrizal', '089699935554', '2007-09-03'),
('TI102135', 'Irma Muliana', '089699935555', '2007-09-03'),
('TI102136', 'Rizki Ananda', '089699935556', '2007-09-04'),
('TI102137', 'Siti Aisyah', '089699935557', '2007-09-04');
