<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset_model extends CI_Model
{
    private $table = "assets";

    /* ================= ASSET MASTER ================= */

    public function getById($asset_id)
    {
        return $this->db
            ->where('asset_id', $asset_id)
            ->get($this->table)
            ->row();
    }

    public function insertAsset($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function updateAsset($asset_id, $data)
    {
        return $this->db
            ->where('asset_id', $asset_id)
            ->update($this->table, $data);
    }

    public function deleteAsset($asset_id)
    {
        return $this->db->delete($this->table, ['asset_id' => $asset_id]);
    }

    public function exists($asset_no)
    {
        return $this->db
            ->where('asset_no', $asset_no)
            ->count_all_results($this->table) > 0;
    }

    /* ================= ASSET LIST ================= */

    // GET ALL ASSETS (LIST PAGE)
    public function getAll()
    {
        return $this->db
            ->select('
                a.asset_id,
                a.asset_no,
                a.asset_name,
                MAX(m.material_code) AS material_code,
                MAX(m.material_id) AS material_id,
                c.cat_no,
                c.cat_name,
                COUNT(ad.assdet_id) AS quantity
            ')
            ->from('assets a')
            ->join('material m', 'm.asset_id = a.asset_id', 'left')
            ->join('categories c', 'c.cat_id = a.type_id', 'left')
            ->join('assdet ad', 'ad.asset_id = a.asset_id', 'left')
            ->group_by('a.asset_id')
            ->order_by('a.asset_id', 'DESC')
            ->get()
            ->result();
    }

    public function getCategories()
    {
        return $this->db->get('categories')->result();
    }

    public function getSites()
    {
        return $this->db->get('sites')->result();
    }

    /* ================= SITE WISE ASSETS (QR / NFC) ================= */

    public function get_assets_by_site($site_id)
    {
        return $this->db
            ->select('
                ad.assdet_id,
                ad.asset_id,
                ad.site_id,
                ad.staff_id,
                ad.verified,
                a.asset_name,
                a.asset_no
            ')
            ->from('assdet ad')
            ->join('assets a', 'a.asset_id = ad.asset_id', 'left')
            ->where('ad.site_id', $site_id)
            ->order_by('a.asset_name', 'ASC')
            ->get()
            ->result();
    }

    /* ================= STAFF WISE ASSETS (A4 PRINT) ================= */

    public function get_assets_with_site_by_staff($staff_id)
    {
        return $this->db
            ->select('
                ad.assdet_id,
                ad.asset_id,
                ad.serial_no,
                ad.site_id,
                ad.staff_id,
                a.asset_name,
                a.asset_no,
                s.site_name,
                s.site_no
            ')
            ->from('assdet ad')
            ->join('assets a', 'a.asset_id = ad.asset_id', 'left')
            ->join('sites s', 's.site_id = ad.site_id', 'left')
            ->where('ad.staff_id', $staff_id)
            ->order_by('a.asset_name', 'ASC')
            ->get()
            ->result();
    }

    /* ================= VERIFY ASSET (ASSDET LEVEL) ================= */

    public function update_assdet_verify($assdet_id, $verified)
    {
        return $this->db
            ->where('assdet_id', $assdet_id)
            ->update('assdet', [
                'verified' => (int)$verified
            ]);
    }

    public function get_asset_count_by_site()
    {
        return $this->db
            ->select('site_id, COUNT(*) AS total')
            ->from('assdet')
            ->group_by('site_id')
            ->get()
            ->result();
    }
    // public function get_asset_by_assdet($assdet_id)
    // {
    //     return $this->db
    //         ->select('
    //         ad.assdet_id,
    //         ad.asset_id,
    //         ad.serial_no,
    //         ad.staff_id,
    //         a.asset_name,
    //         s.site_no,
    //         s.site_name
    //     ')
    //         ->from('assdet ad')
    //         ->join('assets a', 'a.asset_id = ad.asset_id', 'left')
    //         ->join('sites s', 's.site_id = ad.site_id', 'left')
    //         ->where('ad.assdet_id', $assdet_id)
    //         ->get()
    //         ->row();
    // }

    public function get_asset_by_assdet($assdet_id)
{
    return $this->db
        ->select('
            ad.assdet_id,
            ad.asset_id,
            ad.serial_no,
            ad.model_no,
            ad.descr,
            ad.net_val,
            ad.status,
            ad.site_id,
            ad.staff_id,
            a.asset_name,
            s.site_no,
            s.site_name
        ')
        ->from('assdet ad')
        ->join('assets a', 'a.asset_id = ad.asset_id', 'left')
        ->join('sites s', 's.site_id = ad.site_id', 'left')
        ->where('ad.assdet_id', $assdet_id)
        ->get()
        ->row();
}

    public function update_asset_owner($assdet_id, $staff_id)
    {
        return $this->db
            ->where('assdet_id', $assdet_id)
            ->update('assdet', [
                'staff_id' => $staff_id
            ]);
    }
}
