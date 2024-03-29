<?php

namespace App\Traits;

trait EncryptTrait {
    
    public function attributesToArray() {
        $attributes = parent::attributesToArray();
        foreach($this->getEncrypts() as $key) {
            if(array_key_exists($key, $attributes)) {
                $attributes[$key] = decryptss($attributes[$key]);
            }
        }
        return $attributes;
    }

    public function getAttributeValue($key) {
        if(in_array($key, $this->getEncrypts())) {
            return decryptss($this->attributes[$key]);
        }
        return parent::getAttributeValue($key);
    }

    public function setAttribute($key, $value) {
        if(in_array($key, $this->getEncrypts())) {
            $this->attributes[$key] = encryptss($value);
        } else {
            parent::setAttribute($key, $value);
        }
        return $this;
    }

    protected function getEncrypts() {
        return property_exists($this, 'encrypts') ? $this->encrypts : [];
    }

}