// Número de telefon [0-9] com '(', ')' e '-'  
function NumeroTelefone(e) {
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58) || tecla == 40 || tecla == 41 || tecla == 45) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}

// Somente números [0-9]
function SomenteNumero(e) {
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}

// Numeros [0-9] e '-'
function MaskCep(e) {
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58) || tecla == 45) return true;
    else{
        if (tecla==8 || tecla==0) return true;
    else  return false;
    }
}

// Somente letras e espaço
function SomenteLetra(e) {
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>64 && tecla<91) || (tecla>96 && tecla<123) || (tecla == 32)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}

// Somente numero [0-9], '-', '/' e '.'
function NumeroDocumento(e) {
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58) || (tecla == 45) || (tecla == 46) || (tecla == 47)) return true;
    else{
        if (tecla==8 || tecla==0) return true;
    else  return false;
    }
}

function valida_desconto_valor(valor) {
    alert(valor);
    /*if(desconto > valor) {
        alert("O valor de desconto não pode ser maior que o valor da venda.");
        return false;
    } else {
        return true;
    }*/
}
