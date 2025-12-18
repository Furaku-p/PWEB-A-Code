CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255)
);

CREATE TABLE pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    alamat TEXT,
    no_hp VARCHAR(20)
);

CREATE TABLE layanan (
    id_layanan INT AUTO_INCREMENT PRIMARY KEY,
    nama_layanan VARCHAR(100),
    harga_per_kg INT
);

CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan INT,
    id_layanan INT,
    tanggal DATE,
    berat FLOAT,
    total INT,
    status VARCHAR(20)
);

INSERT INTO users VALUES
(
    NULL,
    'admin',
    'admin1234'
);
