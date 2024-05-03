<?php

namespace App\Traits;

trait AttachSessionState {

    use CheckSessionTrait;

    public function attach_session_state($data): array {
        return array_merge([
            "log2user_session_state" => $this->isLogged()
        ], $data);
    }
}