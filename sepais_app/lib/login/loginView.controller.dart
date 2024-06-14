import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/home/home.view.dart';

class LoginController extends GetxController{ //controlador é tudo que vai mexer/conduzir/controlar informações
  TextEditingController emailInput = TextEditingController(); //emailInput
  TextEditingController passwordInput = TextEditingController();
  static const email = 'admin@admin.com';
  static const password = '1234';

  void tryLogin() {
   if(emailInput.text == email){
      checkPassword();
    }else{
      error('Tente um email valido!');
    }
    
}
  void checkPassword(){
    if(passwordInput.text == password){
      print('login concluído!');
      login();
    }else{
      error('Senha incorreta!');
      
    }
  }

   void error(String error){
    print(error);
  }

  void login(){
    Get.to(HomeView());
  }

}

