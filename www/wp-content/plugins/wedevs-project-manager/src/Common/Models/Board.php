<?php

namespace WeDevs\PM\Common\Models;

use WeDevs\PM\Core\DB_Connection\Model as Eloquent;
use WeDevs\PM\Common\Traits\Model_Events;
use WeDevs\PM\Common\Models\Meta;
use WeDevs\PM\Common\Traits\Board_Status;

class Board extends Eloquent {

    use Model_Events, Board_Status;

    protected $table = 'pm_boards';

    protected $fillable = [
        'title',
        'description',
        'order',
        'type',
        'status',
        'project_id',
        'created_by',
        'updated_by',
    ];

    public function metas() {
        return $this->hasMany( 'WeDevs\PM\Common\Models\Meta', 'entity_id' )
            ->whereIn( 'entity_type', [ 'milestone', 'task_list', 'discussion_board' ] );
    }
}
