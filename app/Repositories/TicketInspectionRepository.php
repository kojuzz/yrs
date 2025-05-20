<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\TicketInspection;
use App\Notifications\TwoStepVerification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;
use Exception;
use Illuminate\Support\Facades\Notification;
class TicketInspectionRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = TicketInspection::class;
    }
    public function find($id)
    {
        $record = $this->model::find($id);
        return $record;
    }
    public function create(array $data)
    {
        $record = $this->model::create($data);
        return $record;
    }
    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        $record->update($data);
        return $record;
    }
    public function delete($id)
    {
        $record = $this->model::find($id);
        $record->delete();
        return $record;  
    }
    public function queryByTicketInspector($ticket_inspector)
    {
        return $this->model::where('ticket_inspector_id', $ticket_inspector->id);
    }
}