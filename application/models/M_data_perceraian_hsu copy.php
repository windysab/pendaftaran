
<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_data_perceraian_hsu extends CI_Model
{


	function data_perceraian_hsu($lap_bulan, $lap_tahun)
	{
		
		$sql = "SELECT 
		KECAMATAN,
		SUM(CASE WHEN date_type = 'tanggal_pendaftaran' THEN COUNT ELSE 0 END) AS PERKARA_MASUK,
		SUM(CASE WHEN date_type = 'tanggal_putusan' THEN COUNT ELSE 0 END) AS PERKARA_PUTUS,
		SUM(CASE WHEN date_type = 'tanggal_bht' THEN COUNT ELSE 0 END) AS PERKARA_TELAH_BHT,
		SUM(CASE WHEN date_type = 'tgl_akta_cerai' THEN COUNT ELSE 0 END) AS JUMLAH_AKTA_CERAI
	FROM (
		SELECT 
			CASE 
				WHEN perkara_pihak1.`alamat` LIKE '%Danau Panggang%' THEN 'Danau Panggang'
				WHEN perkara_pihak1.`alamat` LIKE '%Babirik%' THEN 'Babirik'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
				WHEN perkara_pihak1.`alamat` LIKE '%Banjang%' THEN 'Banjang'
				WHEN perkara_pihak1.`alamat` LIKE '%Haur Gading%' THEN 'Haur Gading'
				WHEN perkara_pihak1.`alamat` LIKE '%Paminggir%' THEN 'Paminggir'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
				ELSE 'BALANGAN'
			END AS KECAMATAN,
			'tgl_akta_cerai' AS date_type, COUNT(*) AS COUNT
		FROM perkara
		LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
		LEFT JOIN perkara_akta_cerai ON perkara.`perkara_id`=perkara_akta_cerai.`perkara_id`
		WHERE YEAR(tgl_akta_cerai)='$lap_tahun' AND MONTH(tgl_akta_cerai)='$lap_bulan'
		AND perkara_pihak1.`urutan`='1'
		GROUP BY KECAMATAN
		-- Repeat the above subquery for 'tanggal_pendaftaran', 'tanggal_putusan', 'tanggal_bht'
		UNION ALL
		SELECT 
			CASE 
				WHEN perkara_pihak1.`alamat` LIKE '%Danau Panggang%' THEN 'Danau Panggang'
				WHEN perkara_pihak1.`alamat` LIKE '%Babirik%' THEN 'Babirik'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
				WHEN perkara_pihak1.`alamat` LIKE '%Banjang%' THEN 'Banjang'
				WHEN perkara_pihak1.`alamat` LIKE '%Haur Gading%' THEN 'Haur Gading'
				WHEN perkara_pihak1.`alamat` LIKE '%Paminggir%' THEN 'Paminggir'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
			   ELSE 'BALANGAN'
			END AS KECAMATAN,
			'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
		FROM perkara
		LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
		WHERE YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan'
		AND perkara_pihak1.`urutan`='1'
		GROUP BY KECAMATAN
		UNION ALL
		SELECT 
		CASE 
			WHEN perkara_pihak1.`alamat` LIKE '%Danau Panggang%' THEN 'Danau Panggang'
			WHEN perkara_pihak1.`alamat` LIKE '%Babirik%' THEN 'Babirik'
			WHEN perkara_pihak1.`alamat` LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
			WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
			WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
			WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
			WHEN perkara_pihak1.`alamat` LIKE '%Banjang%' THEN 'Banjang'
			WHEN perkara_pihak1.`alamat` LIKE '%Haur Gading%' THEN 'Haur Gading'
			WHEN perkara_pihak1.`alamat` LIKE '%Paminggir%' THEN 'Paminggir'
			WHEN perkara_pihak1.`alamat` LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
			ELSE 'BALANGAN'
		END AS KECAMATAN,
		'tanggal_putusan' AS date_type, COUNT(*) AS COUNT
	FROM perkara
	LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
	LEFT JOIN perkara_putusan ON perkara.`perkara_id`=perkara_putusan.`perkara_id`
	WHERE YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan'
	AND perkara_pihak1.`urutan`='1'
	GROUP BY KECAMATAN
		UNION ALL
		SELECT 
			CASE 
				WHEN perkara_pihak1.`alamat` LIKE '%Danau Panggang%' THEN 'Danau Panggang'
				WHEN perkara_pihak1.`alamat` LIKE '%Babirik%' THEN 'Babirik'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
				WHEN perkara_pihak1.`alamat` LIKE '%Banjang%' THEN 'Banjang'
				WHEN perkara_pihak1.`alamat` LIKE '%Haur Gading%' THEN 'Haur Gading'
				WHEN perkara_pihak1.`alamat` LIKE '%Paminggir%' THEN 'Paminggir'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
				ELSE 'BALANGAN'
			END AS KECAMATAN,
			'tanggal_bht' AS date_type, COUNT(*) AS COUNT
		FROM perkara
		LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
		LEFT JOIN perkara_putusan ON perkara.perkara_id=perkara_putusan.perkara_id
	LEFT JOIN perkara_akta_cerai ON perkara.perkara_id=perkara_akta_cerai.perkara_id
		WHERE YEAR(tanggal_bht)='$lap_tahun' AND MONTH(tanggal_bht)='$lap_bulan'
		AND perkara_pihak1.`urutan`='1'
		GROUP BY KECAMATAN
	
	) AS subquery
	WHERE KECAMATAN IN ('Danau Panggang', 'Babirik', 'Sungai Pandan', 'Amuntai Selatan', 'Amuntai Tengah', 'Amuntai Utara', 'Banjang', 'Haur Gading', 'Paminggir', 'Sungai Tabukan')
	GROUP BY KECAMATAN
	UNION ALL
	SELECT 
		'TOTAL',
		SUM(CASE WHEN date_type = 'tanggal_pendaftaran' THEN COUNT ELSE 0 END),
		SUM(CASE WHEN date_type = 'tanggal_putusan' THEN COUNT ELSE 0 END),
		SUM(CASE WHEN date_type = 'tanggal_bht' THEN COUNT ELSE 0 END),
		SUM(CASE WHEN date_type = 'tgl_akta_cerai' THEN COUNT ELSE 0 END)
	FROM (
		SELECT 
			CASE 
				WHEN perkara_pihak1.`alamat` LIKE '%Danau Panggang%' THEN 'Danau Panggang'
				WHEN perkara_pihak1.`alamat` LIKE '%Babirik%' THEN 'Babirik'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
				WHEN perkara_pihak1.`alamat` LIKE '%Banjang%' THEN 'Banjang'
				WHEN perkara_pihak1.`alamat` LIKE '%Haur Gading%' THEN 'Haur Gading'
				WHEN perkara_pihak1.`alamat` LIKE '%Paminggir%' THEN 'Paminggir'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
				ELSE 'BALANGAN'
			END AS KECAMATAN,
			'tgl_akta_cerai' AS date_type, COUNT(*) AS COUNT
		FROM perkara
		LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
		LEFT JOIN perkara_akta_cerai ON perkara.`perkara_id`=perkara_akta_cerai.`perkara_id`
		WHERE YEAR(tgl_akta_cerai)='$lap_tahun' AND MONTH(tgl_akta_cerai)='$lap_bulan'
		AND perkara_pihak1.`urutan`='1'
		GROUP BY KECAMATAN
		-- Repeat the above subquery for 'tanggal_pendaftaran', 'tanggal_putusan', 'tanggal_bht'
		UNION ALL
		SELECT 
			CASE 
				WHEN perkara_pihak1.`alamat` LIKE '%Danau Panggang%' THEN 'Danau Panggang'
				WHEN perkara_pihak1.`alamat` LIKE '%Babirik%' THEN 'Babirik'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
				WHEN perkara_pihak1.`alamat` LIKE '%Banjang%' THEN 'Banjang'
				WHEN perkara_pihak1.`alamat` LIKE '%Haur Gading%' THEN 'Haur Gading'
				WHEN perkara_pihak1.`alamat` LIKE '%Paminggir%' THEN 'Paminggir'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
			   ELSE 'BALANGAN'
			END AS KECAMATAN,
			'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
		FROM perkara
		LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
		WHERE YEAR(tanggal_pendaftaran)='$lap_tahun' AND MONTH(tanggal_pendaftaran)='$lap_bulan'
		AND perkara_pihak1.`urutan`='1'
		GROUP BY KECAMATAN
		UNION ALL
		SELECT 
		CASE 
			WHEN perkara_pihak1.`alamat` LIKE '%Danau Panggang%' THEN 'Danau Panggang'
			WHEN perkara_pihak1.`alamat` LIKE '%Babirik%' THEN 'Babirik'
			WHEN perkara_pihak1.`alamat` LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
			WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
			WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
			WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
			WHEN perkara_pihak1.`alamat` LIKE '%Banjang%' THEN 'Banjang'
			WHEN perkara_pihak1.`alamat` LIKE '%Haur Gading%' THEN 'Haur Gading'
			WHEN perkara_pihak1.`alamat` LIKE '%Paminggir%' THEN 'Paminggir'
			WHEN perkara_pihak1.`alamat` LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
			ELSE 'BALANGAN'
		END AS KECAMATAN,
		'tanggal_putusan' AS date_type, COUNT(*) AS COUNT
	FROM perkara
	LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
	LEFT JOIN perkara_putusan ON perkara.`perkara_id`=perkara_putusan.`perkara_id`
	WHERE YEAR(tanggal_putusan)='$lap_tahun' AND MONTH(tanggal_putusan)='$lap_bulan'
	AND perkara_pihak1.`urutan`='1'
	GROUP BY KECAMATAN
		UNION ALL
		SELECT 
			CASE 
				WHEN perkara_pihak1.`alamat` LIKE '%Danau Panggang%' THEN 'Danau Panggang'
				WHEN perkara_pihak1.`alamat` LIKE '%Babirik%' THEN 'Babirik'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Pandan%' THEN 'Sungai Pandan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Selatan%' THEN 'Amuntai Selatan'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Tengah%' THEN 'Amuntai Tengah'
				WHEN perkara_pihak1.`alamat` LIKE '%Amuntai Utara%' THEN 'Amuntai Utara'
				WHEN perkara_pihak1.`alamat` LIKE '%Banjang%' THEN 'Banjang'
				WHEN perkara_pihak1.`alamat` LIKE '%Haur Gading%' THEN 'Haur Gading'
				WHEN perkara_pihak1.`alamat` LIKE '%Paminggir%' THEN 'Paminggir'
				WHEN perkara_pihak1.`alamat` LIKE '%Sungai Tabukan%' THEN 'Sungai Tabukan'
				ELSE 'BALANGAN'
			END AS KECAMATAN,
			'tanggal_bht' AS date_type, COUNT(*) AS COUNT
		FROM perkara
		LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
		LEFT JOIN perkara_putusan ON perkara.perkara_id=perkara_putusan.perkara_id
	LEFT JOIN perkara_akta_cerai ON perkara.perkara_id=perkara_akta_cerai.perkara_id
		WHERE YEAR(tanggal_bht)='$lap_tahun' AND MONTH(tanggal_bht)='$lap_bulan'
		AND perkara_pihak1.`urutan`='1'
		GROUP BY KECAMATAN
	
	) AS subquery
	WHERE KECAMATAN IN ('Danau Panggang', 'Babirik', 'Sungai Pandan', 'Amuntai Selatan', 'Amuntai Tengah', 'Amuntai Utara', 'Banjang', 'Haur Gading', 'Paminggir', 'Sungai Tabukan')
	ORDER BY KECAMATAN";
        $query = $this->db->query($sql);
        return $query->result();
	}
}
