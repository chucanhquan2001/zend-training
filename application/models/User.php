<?php

class Application_Model_User
{
    protected $_name;
    protected $_phone;
    protected $_email;
    protected $_password;
    protected $_created_at;
    protected $_updated_at;
    protected $_id;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Không hợp lệ');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Không hợp lệ !');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        // var_dump($this); die;
        return $this;
    }

    public function setName($text)
    {
        $this->_name = (string) $text;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setPhone($phone)
    {
        $this->_phone = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->_password;
    }


    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setCreatedAt($createdAt)
    {
        $this->_created_at = $createdAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->_created_at;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->_updated_at = $updatedAt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->_updated_at;
    }
}
