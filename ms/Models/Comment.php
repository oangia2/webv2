<?php
namespace MS\Models;

use oangia\MongoDB\Model;

class Comment extends Model {
    public static $fields = ['user_id', 'post_id', 'url', 'email', 'author', 'ip', 'user_agent', 'content', 'host', 'rating', 'verified', 'approved', 'published_on', 'parent_id'];
    public static $collection = 'comments';

    public function rating() {
        $rating = 0;
        foreach ($this->documents as $document) {
            $rating += $document->rating;
        }
        return $rating/$this->totalDocuments;
    }
}