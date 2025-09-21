<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $name
 * @property int $level
 * @property int $employee_count
 * @property int|null $parent_department_id
 * @property string|null $ambassador_first_name
 * @property string|null $ambassador_last_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property bool|null $is_active
 * 
 * @property Department|null $department	
 * @property Collection|Department[] $departments
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';

	protected $casts = [
		'level' => 'int',
		'employee_count' => 'int',
		'parent_department_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'level',
		'employee_count',
		'parent_department_id',
		'ambassador_first_name',
		'ambassador_last_name',
		'is_active'
	];

	public function department()
	{
		return $this->belongsTo(Department::class, 'parent_department_id');
	}

	public function departments()
	{
		return $this->hasMany(Department::class, 'parent_department_id');
	}
}
