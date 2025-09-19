<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TblUser
 *
 * @property int $id_user
 * @property int|null $id_role
 * @property string|null $username
 * @property string|null $full_name
 * @property string|null $password
 * @property Carbon|null $create_on
 * @property Carbon|null $last_login
 * @property bool $block
 *
 * @property Collection|MasterpartHino[] $masterpart_hinos
 * @property Collection|MasterpartHpm[] $masterpart_hpms
 * @property Collection|MasterpartMmki[] $masterpart_mmkis
 * @property Collection|MasterpartTmmin[] $masterpart_tmmins
 * @property Collection|TblDeliverynote[] $tbl_deliverynotes
 * @property Collection|TblKbndelivery[] $tbl_kbndeliveries
 *
 * @package App\Models
 */
class TblUser extends Authenticatable
{
	protected $table = 'tbl_user';
	protected $primaryKey = 'id_user';
	public $timestamps = false;

	protected $casts = [
		'id_role' => 'int',
		'create_on' => 'datetime',
		'last_login' => 'datetime',
		'block' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'id_role',
		'username',
		'full_name',
		'password',
		'create_on',
		'last_login',
		'block',
        'chance',
        'is_blocked'
	];

	public function masterpart_hinos()
	{
		return $this->hasMany(MasterpartHino::class, 'user');
	}

	public function masterpart_hpms()
	{
		return $this->hasMany(MasterpartHpm::class, 'user');
	}

	public function masterpart_mmkis()
	{
		return $this->hasMany(MasterpartMmki::class, 'user');
	}

	public function masterpart_tmmins()
	{
		return $this->hasMany(MasterpartTmmin::class, 'user');
	}

	public function tbl_deliverynotes()
	{
		return $this->hasMany(TblDeliverynote::class, 'user');
	}

	public function tbl_kbndeliveries()
	{
		return $this->hasMany(TblKbndelivery::class, 'user');
	}

    public function validatePassword($plainPassword){
        return md5($plainPassword) === $this->password;
    }

    public function input_log() {
        return $this->hasMany(TblInputLog::class, 'scanned_by');
    }

    public function role() {
        return $this->belongsTo(TblRole::class, 'id_role');
    }

    public function isActive() {
        return !$this->is_blocked;
    }

    public function scopeSearch($query, $term){
        return $query
            ->where('username', 'like', '%' . $term . '%')
            ->orWhere('full_name', 'like', '%' . $term . '%');
    }

    public function message() {
        return $this->hasMany(Message::class, 'sender');
    }
}
