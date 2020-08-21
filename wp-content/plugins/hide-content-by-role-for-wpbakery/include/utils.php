<?php

class HCBRWPB_Utils{

	static function user_has_role( $user_id, $role ) {

		$user = get_userdata( $user_id );

		if ( ! $user ) {
			return false;
		}

		return in_array( $role, $user->roles, true );
	}

}
