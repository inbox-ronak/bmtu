<?php 
namespace App\Models;
use CodeIgniter\Model;
class CollegeModel extends Model
{
    protected $table = 'college';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['college_name', 'status'];
}