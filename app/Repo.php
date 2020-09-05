<?php

namespace App;

use Github\Client as GHClient;
use Illuminate\Database\Eloquent\Model;

class Repo extends Model
{
    //

    protected $fillable = ['name', 'user_id', 'message', 'post_report_message', 'default_issue_label'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function issues()
    {
        $ghclient = new GHClient();
        $ghclient->authenticate($this->user->accesstoken, GHClient::AUTH_ACCESS_TOKEN);
        $explodedname = explode('/', $this->name);
        $issues = $ghclient->issue()->all($explodedname[0], $explodedname[1], array('state' => 'open'));
        return $issues;
    }
}
