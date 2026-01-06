<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bom_model extends CI_Model
{

    // get_all()
    // get_by_parent($parent_material_id)
    // insert($data)
    // update($bom_id, $data)
    // delete($bom_id)

  public function get_all()
{
    return $this->db
        ->select('
            b.*,
            pm.material_code AS parent_material,
            cm.material_code AS child_material,
            u.uom_name,
            u.uom_code
        ')
        ->from('bom b')
        ->join('material pm', 'pm.material_id = b.parent_material_id')
        ->join('material cm', 'cm.material_id = b.child_material_id')
        ->join('uom_master u', 'u.uom_id = b.uom', 'left')
        ->order_by('b.bom_id', 'DESC')
        ->get()
        ->result();
}


    

    public function get_by_id($bom_id)
    {
        return $this->db
            ->where('bom_id', $bom_id)
            ->get('bom')
            ->row();
    }

    public function insert($data)
    {
        return $this->db->insert('bom', $data);
    }

    public function update($bom_id, $data)
    {
        return $this->db
            ->where('bom_id', $bom_id)
            ->update('bom', $data);
    }

    public function delete($bom_id)
    {
        return $this->db
            ->where('bom_id', $bom_id)
            ->delete('bom');
    }

    public function get_by_id_with_material($id)
    {
        return $this->db
            ->select('b.*, 
                  pm.material_code AS parent_material,
                  cm.material_code AS child_material')
            ->from('bom b')
            ->join('material pm', 'pm.material_id=b.parent_material_id')
            ->join('material cm', 'cm.material_id=b.child_material_id')
            ->where('b.bom_id', $id)
            ->get()
            ->row();
    }
    // Material wise BOM (child list)
  public function get_by_parent_material($material_id)
{
    return $this->db
        ->select('
            b.bom_id,
            b.qty,
            u.uom_name,
            u.uom_code,
            m.material_code AS child_name
        ')
        ->from('bom b')
        ->join('material m', 'm.material_id = b.child_material_id')
        ->join('uom_master u', 'u.uom_id = b.uom', 'left')
        ->where('b.parent_material_id', $material_id)
        ->order_by('b.bom_id', 'ASC')
        ->get()
        ->result();
}


}
