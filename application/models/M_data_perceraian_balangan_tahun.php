
<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_data_perceraian_balangan_tahun extends CI_Model
{


	function data_perceraian_balangan_tahun($lap_tahun)
	{
		$sql = "SELECT 
		all_kecamatan.KECAMATAN,
		COALESCE(subquery.PERKARA_MASUK, 0) AS PERKARA_MASUK
	FROM (
		SELECT 'Paringin' AS KECAMATAN
		UNION ALL SELECT 'Paringin Selatan'
		UNION ALL SELECT 'Lampihong'
		UNION ALL SELECT 'Batumandi'
		UNION ALL SELECT 'Awayan'
		UNION ALL SELECT 'Halong'
		UNION ALL SELECT 'Tebing Tinggi'
		UNION ALL SELECT 'Juai'
	) AS all_kecamatan
	LEFT JOIN (
		SELECT 
			KECAMATAN,
			SUM(CASE WHEN date_type = 'tanggal_pendaftaran' THEN COUNT ELSE 0 END) AS PERKARA_MASUK
		FROM (
			SELECT 
				CASE 
				WHEN perkara_pihak1.`alamat` LIKE '%Paringin Selatan%' THEN 'Paringin Selatan'
					WHEN perkara_pihak1.`alamat` LIKE '%Paringin%' THEN 'Paringin'
					WHEN perkara_pihak1.`alamat` LIKE '%Lampihong%' THEN 'Lampihong'
					WHEN perkara_pihak1.`alamat` LIKE '%Batumandi%' THEN 'Batumandi'
					WHEN perkara_pihak1.`alamat` LIKE '%Awayan%' THEN 'Awayan'
					WHEN perkara_pihak1.`alamat` LIKE '%Halong%' THEN 'Halong'
					WHEN perkara_pihak1.`alamat` LIKE '%Tebing Tinggi%' THEN 'Tebing Tinggi'
					WHEN perkara_pihak1.`alamat` LIKE '%Juai%' THEN 'Juai'                
					ELSE 'HULU SUNGAI UTARA'
				END AS KECAMATAN,
				'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
			FROM perkara
			LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
			WHERE YEAR(tanggal_pendaftaran)='$lap_tahun' 
			AND perkara_pihak1.`urutan`='1'
			GROUP BY KECAMATAN
		) AS subquery
		GROUP BY KECAMATAN
	) AS subquery ON all_kecamatan.KECAMATAN = subquery.KECAMATAN
	UNION ALL
	SELECT 
		'TOTAL' AS KECAMATAN,
		SUM(PERKARA_MASUK) AS PERKARA_MASUK
	FROM (
		SELECT 
			KECAMATAN,
			SUM(CASE WHEN date_type = 'tanggal_pendaftaran' THEN COUNT ELSE 0 END) AS PERKARA_MASUK
		FROM (
			SELECT 
				CASE 
				WHEN perkara_pihak1.`alamat` LIKE '%Paringin Selatan%' THEN 'Paringin Selatan'
					WHEN perkara_pihak1.`alamat` LIKE '%Paringin%' THEN 'Paringin'
					WHEN perkara_pihak1.`alamat` LIKE '%Lampihong%' THEN 'Lampihong'
					WHEN perkara_pihak1.`alamat` LIKE '%Batumandi%' THEN 'Batumandi'
					WHEN perkara_pihak1.`alamat` LIKE '%Awayan%' THEN 'Awayan'
					WHEN perkara_pihak1.`alamat` LIKE '%Halong%' THEN 'Halong'
					WHEN perkara_pihak1.`alamat` LIKE '%Tebing Tinggi%' THEN 'Tebing Tinggi'
					WHEN perkara_pihak1.`alamat` LIKE '%Juai%' THEN 'Juai'                
					ELSE 'HULU SUNGAI UTARA'
				END AS KECAMATAN,
				'tanggal_pendaftaran' AS date_type, COUNT(*) AS COUNT
			FROM perkara
			LEFT JOIN perkara_pihak1 ON perkara.`perkara_id`=perkara_pihak1.`perkara_id`
			WHERE YEAR(tanggal_pendaftaran)='$lap_tahun' 
			AND perkara_pihak1.`urutan`='1'
			GROUP BY KECAMATAN
		) AS subquery
		WHERE KECAMATAN IN ('Paringin', 'Paringin Selatan', 'Lampihong', 'Batumandi', 'Awayan', 'Halong', 'Tebing Tinggi', 'Juai')
		GROUP BY KECAMATAN
	) AS subquery";
	
		$query = $this->db->query($sql);
		return $query->result();
	}
	
}
