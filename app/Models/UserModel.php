<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public $table = 'pengguna';
    protected $primaryKey = 'pengguna_id';
    protected $allowedFields = ['nama_lengkap','username','tingkat','password','sign_in_terakhir'];

    public function getDataUserSignIn(string $username): ? array
    {
        return $this->select('nama_lengkap, tingkat, password, pengguna_id')->getWhere(['username' => $username])->getRowArray();
    }

    public function getUsers(): array
    {
        return $this->select('pengguna_id, nama_lengkap, tingkat, sign_in_terakhir')->orderBy('nama_lengkap', 'ASC')->get()->getResultArray();
    }

    public function findUser(string $user_id, string $column): ? array
    {
        return $this->select($column)->getWhere([$this->primaryKey => $user_id])->getRowArray();
    }

    public function removeUser(string $user_id): bool
    {
        try {
            $this->where('pengguna_id !=', $_SESSION['posw_user_id'])->delete($user_id);
            return true;
        } catch (\ErrorException $e) {
            return false;
        }
    }
}
