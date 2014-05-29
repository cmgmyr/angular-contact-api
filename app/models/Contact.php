<?php

class Contact extends Eloquent {
	protected $fillable = ['first_name', 'last_name', 'email', 'phone'];

    protected $hidden = ['created_at', 'updated_at'];
}