<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailCustomResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->news_content,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'writer' => [
                'id' => $this->author,
                'username' => $this->writer->username,
                'email' => $this->writer->email,
                'first_name' => $this->writer->firstname,
                'join_at' => date_format($this->writer->created_at, "Y/m/d H:i:s"),
            ],
        ];
    }
}
