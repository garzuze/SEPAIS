import 'package:flutter/material.dart';
import 'package:sepais/assets/preguica.dart';

class HomeView extends StatelessWidget {
  const HomeView({super.key});

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
    return Container();
  }

