<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Enum\RoleSessionEnum;

trait CurrentSessionTrait {
    // private Request $req;
    public RoleSessionEnum $cookie_role;
    public bool $cookie_status;
    public string $cookie_identity;
    public ?string $cookie_kelas;

    public function cookie_deserialize() {
        $this->make_object();
    }

    protected function do_unserialize(): array
    {
        return unserialize($this->request->cookie("login_data"));
    }

    protected function make_object()
    {
        $deserialized = $this->do_unserialize();

        $this->cookie_status = (($deserialized["status"] == "true" ? true : false));
        $this->cookie_role = match($deserialized["role"]) {
            "student" => RoleSessionEnum::Student,
            "superadmin" => RoleSessionEnum::SuperAdmin,
            "pengajar" => RoleSessionEnum::Pengajar
        };
        $this->cookie_identity = $deserialized["identity"];
        $this->cookie_kelas = $deserialized["kelas"];
    }
}