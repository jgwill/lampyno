<?php

namespace WeDevs\PM\Core\Permissions;

use WeDevs\PM\Core\Permissions\Abstract_Permission;
use WeDevs\PM\File\Models\File;
use WP_REST_Request;

class Edit_File extends Abstract_Permission {
   
    public function check() {
        $id = $this->request->get_param( 'file_id' );
        $project_id = $this->request->get_param( 'project_id' );
        $user_id = get_current_user_id();

        if ( $user_id ) {

        	if ( $project_id && pm_has_project_managing_capability( $project_id, $user_id ) ) {
	            return true;
	        }

            $file =  File::find( $id );
	        if ( $file && $file->created_by == $user_id ){
	        	return true;
	        }

        }

        return new \WP_Error( 'File', __( "You have no permission.", "wedevs-project-manager" ) );
    }
}