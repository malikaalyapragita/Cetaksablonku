<?php namespace App\Models; use CodeIgniter\Model;
class DesainTugasModel extends Model {
    protected $table = 'desain_tugas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'designer_id', 'file_hasil_desain', 'catatan_desain', 'status_desain'];
}