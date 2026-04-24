<?
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pelanggaran extends Model
{
    protected $fillable = [
        'Pelapor',
        'Terlapor',
        'tipe_pelanggaran_id',
        'catatan',
        'foto'
    ];
}