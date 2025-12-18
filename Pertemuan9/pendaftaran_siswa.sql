SET NAMES utf8mb4;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `siswa` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(100) NOT NULL,
    `alamat` TEXT NOT NULL,
    `jenis_kelamin` ENUM('Laki-laki','Perempuan') NOT NULL,
    `agama` VARCHAR(30) NOT NULL,
    `sekolah_asal` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
