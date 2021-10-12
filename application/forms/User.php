<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        $this->setAttrib('role', 'form');

        // ẩn field
        $user_id = new Zend_Form_Element_Hidden('id');
        $user_id->setAttrib('class', 'form-control');
        $user_id->setDecorators(
            $this->getBootstrapDecorator()
        );
        $this->addElement($user_id);

        // thêm họ tên
        $name = new Zend_Form_Element_Text('name');
        $name->setAttrib('class', 'form-control');
        $name->setAttrib('placeholder', 'Nhập họ tên !');
        $name->setDecorators(
            $this->getBootstrapDecorator()
        );
        $name->setLabel('Họ tên:');
        $name->setRequired(true);
        $name->addValidators([
            [
                'validator'           => 'NotEmpty',
                'options' => [
                    'messages' => 'Họ tên không được để trống !'
                ]
            ],
            [
                'validator' => 'stringLength',
                'options'   => [
                    0, 255,
                    'messages' => 'Độ dài không hợp lệ !'
                ],
            ],
        ]);
        $this->addElement($name);

        // thêm số điện thoại
        $phone = new Zend_Form_Element_Text('phone');
        $phone->setAttrib('class', 'form-control');
        $phone->setAttrib('placeholder', 'Nhập số điện thoại !');
        $phone->setDecorators(
            $this->getBootstrapDecorator()
        );
        $phone->setLabel('Số điện thoại:');
        $phone->setRequired(true);
        $phone->addValidators([
            [
                'validator'           => 'NotEmpty',
                'options' => [
                    'messages' => 'Số điện thoại không được để trống !'
                ]
            ],
            [
                'validator' => 'Regex',
                'options'   => [
                    '/(^[\+]{0,1}+(84){1}+[0-9]{9})|((^0)(32|33|34|35|36|37|38|39|56|58|59|70|76|77|78|79|81|82|83|84|85|86|88|89|90|92|91|93|94|96|97|98|99)+([0-9]{7}))$/',
                    'messages' => 'Số điện thoại không hợp lệ'
                ],

            ]
        ]);
        // $phone->getValidator('Regex')->setMessage('Số điện thoại không hợp lệ !');
        $this->addElement($phone);

        // thêm email
        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('class', 'form-control');
        $email->setAttrib('placeholder', 'Nhập email !');
        $email->setDecorators(
            $this->getBootstrapDecorator()
        );
        $email->setLabel('Email:');
        $email->setRequired(true);

        $email->addValidators([
            [
                'validator'           => 'NotEmpty',
                'options' => [
                    'messages' => 'Email không được để trống !'
                ]
            ],
            [
                'validator' => 'stringLength',
                'options'   => [
                    0, 255,
                    'messages' => 'Độ dài không hợp lệ !'
                ],
            ],
            [
                'validator' => 'EmailAddress',
                'options'   => [
                    TRUE,
                    'messages' => 'Email không hợp lệ !'
                ],
            ],
            [
                'validator' => 'Db_NoRecordExists',
                'options' => [
                    'table' => 'users',
                    'field' => 'email',
                    'messages' => 'Email đã tồn tại !',
                    // 'exclude' => [
                    //     'field' => 'id', 
                    //     'value' => $this->request->getPost()['id']
                    // ]
                ]
            ]
        ]);
        $this->addElement($email);

        // thêm mật khẩu
        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('class', 'form-control');
        $password->setAttrib('placeholder', 'Nhập mật khẩu !');
        $password->setDecorators(
            $this->getBootstrapDecorator()
        );
        $password->setLabel('Mật khẩu:');
        $password->setRequired(true);
        $password->addValidators([
            [
                'validator'           => 'NotEmpty',
                'options' => [
                    'messages' => 'Mật khẩu không được để trống !'
                ]
            ],
            [
                'validator' => 'stringLength',
                'options'   => [
                    6, 20,
                    'messages' => 'Độ dài không hợp lệ !'
                ]
            ],
        ]);
        $this->addElement($password);

        // xác nhận mật khẩu
        $password_cf = new Zend_Form_Element_Password('password_cf');
        $password_cf->setAttrib('class', 'form-control');
        $password_cf->setAttrib('placeholder', 'Xác nhận mật khẩu !');
        $password_cf->setDecorators(
            $this->getBootstrapDecorator()
        );
        $password_cf->setLabel('Xác nhận lại mật khẩu:');
        $password_cf->setRequired(true);
        $password_cf->addValidators([
            [
                'validator'           => 'NotEmpty',
                'options' => [
                    'messages' => 'Xác nhận mật khẩu không được để trống !'
                ]
            ],
            [
                'validator'           => 'Identical',
                'options' => [
                    'token' => 'password',
                    'messages' => 'Xác nhận mật khẩu không chính xác !'
                ]
            ]
        ]);
        $this->addElement($password_cf);
    }

    /**
     * Apply Bootstrap decorators to an element.
     * @return array
     */
    private function getBootstrapDecorator()
    {
        return [
            'ViewHelper',
            'Description',
            'Errors',
            [
                'Label',
                [
                    'tag' => 'label',
                    'class' => 'control-label'
                ]
            ],
            [
                'HtmlTag',
                [
                    'tag' => 'div',
                    'class' => 'form-group'
                ]
            ]
        ];
    }
}
