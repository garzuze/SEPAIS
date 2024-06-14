import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/login/loginView.controller.dart';
import 'package:sepais/login/widgets/emailField.widget.dart';
import 'package:sepais/login/widgets/loginButton.widget.dart';
import 'package:sepais/login/widgets/passwordField.widget.dart';
import 'package:sepais/assets/preguica.dart';
import 'package:sepais/registrar/register.view.dart';

class LoginView  extends GetView<LoginController> {
  const LoginView ({super.key});

  @override
  Widget build(BuildContext context) {

    return Scaffold(
      appBar: ab.appbar(),
     
      body: _body(),
    );
  }
}
 
AppbarSepais ab = AppbarSepais(); //appbar design var

  _body(){
    return Center(
      child: ListView(
        shrinkWrap: true,
        padding: const EdgeInsets.all(12),
        children:  [
        SizedBox(height: Get.height / 3, 
        ), //divide o tamanho da 'box' na tela em 3x
        EmailField(), 
        SizedBox(height: 27),
        Divider(),
        PasswordField(), 
        SizedBox(height: 40),
        LoginButton(),
        ElevatedButton(onPressed: (){Get.to(() => RegisterView());
        }, child: Text('Crie sua conta')),
        ],
        
      ),
    );
  }
  

