<?php
// Change name space as your need
// Source https://stackoverflow.com/questions/49503230/encryption-and-decryption-in-laravel-5
// Usage in model is after the trait 
// Use it in your models as there
// Tested in laravel 6 
//
namespace App\Traits;

trait EncryptTrait {

    public function attributesToArray() {
        $attributes = parent::attributesToArray();
        foreach($this->getEncrypts() as $key) {
            if(array_key_exists($key, $attributes)) {
                $attributes[$key] = decrypt($attributes[$key]);
            }
        }
        return $attributes;
    }

    public function getAttributeValue($key) {
        if(in_array($key, $this->getEncrypts())) {
            return decrypt($this->attributes[$key]);
        }
        return parent::getAttributeValue($key);
    }

    public function setAttribute($key, $value) {
        if(in_array($key, $this->getEncrypts())) {
            $this->attributes[$key] = encrypt($value);
        } else {
            parent::setAttribute($key, $value);
        }
        return $this;
    }

    protected function getEncrypts() {
        return property_exists($this, 'encrypts') ? $this->encrypts : [];
    }

}


// Here is the example where the trait is called in the model
use App\Traits\EncryptTrait;
class Post extends Model
{
    use EncryptTrait;

    protected $encrypts = ['name', 'description'];

}