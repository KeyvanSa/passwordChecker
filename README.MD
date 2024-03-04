# Password Checker API with PHP
## PHP Version 8.0

## Description
This project is written using PHP language.
Using this project, you can measure the security of your passwords and also create safe passwords.
## Featueres

1. Checking passwords considering:
* Password length (secure password must contain 8 characters or more)
* numbers
* alphabet
* Uppercase and lowercase letters
* special text characters like @#$%^&*)(_-

2. Creating a secure password including numbers, alphabets, special text characters for use in registering sites, programs, etc.

## Use this project

To check your password, just send the password in the following json request format.
``` php
POST Method : http://localhost/passwordChecker/checkPassword/check
```

``` json
{
   "password":"your Password"
}
```
Sample Response to check password
``` json
{
    "status": "ok",
    "message": "رمز باید حداقل شامل یک نماد باشد",
    "data": {
        "password": "1235ddljhsdflFDSDFgr",
        "score": 80,
        "max_score": 100
    }
}
```

To generate a secure password, you must send a request in json request format.
``` php
POST Method : http://localhost/passwordChecker/checkPassword/generation
```
``` json
{
    "length":10,
    "useNumbers":"true",
    "useUppercase":"true",
    "useLowercase":"true",
    "useSymbols":"true"
}
```
Sample Response to generation password
``` json
{
    "status": "ok",
    "message": "",
    "data": {
        "password": "qJtiAe@Dk4)vF~f27O%)t^(iY1#8H2"
    }
}
```

## contribution
contributions are welcome. to contribute to the improvement of the app , make suggestions, or report issues, you can open an issue or send a pull request.

## Task lists
- [x] Create Base API Project
- [ ] add score to generation password
