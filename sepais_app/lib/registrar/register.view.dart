import 'package:flutter/material.dart';
import 'package:sepais/assets/preguica.dart';
import 'package:sepais/registrar/widgets/cpfRegisterField.widget.dart';
import 'package:sepais/registrar/widgets/emailRegisterField.widget.dart';
import 'package:sepais/registrar/widgets/nameRegisterField.widget.dart';
import 'package:sepais/registrar/widgets/passwordConfirmRegisterField.widget.dart';
import 'package:sepais/registrar/widgets/passwordRegisterField.widget.dart';
import 'package:sepais/registrar/widgets/registerButton.widget.dart';

class RegisterView extends StatelessWidget {
  const RegisterView({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: ab.appbar(),
      body: _body(),
    );
  }
}

AppbarSepais ab = AppbarSepais();

_body() {
  return Center(
    child: ListView(
      shrinkWrap: true,
      padding: const EdgeInsets.all(12),
      children: [
        Center(
            child: Text(
          'Insira suas credênciais iguais ao da escola',
          style: TextStyle(
            fontSize: 20.0,
          ),
        )),
        NameRegisterField(),
        SizedBox(height: 20),
        CpfRegisterField(),
        SizedBox(height: 20),
        EmailRegisterField(),
        SizedBox(height: 20),
        PasswordRegisterField(),
        SizedBox(height: 20),
        PasswordConfirmRegisterField(),
        SizedBox(height: 20),
        RegisterButton()
      ],
    ),
  );
}
