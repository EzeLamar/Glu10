<h1> Entidades y Relaciones:
<h3>Restaurante(++IDR++, Nombre, Ubicación, tieneMenuCel, CalificacionFinal);</h3>


<h3>Usuario(++IDU++, Nombre, Apellido, edad, email, passwd, NroTelefono, esCeliaco, tokenFacebook);</h3>

<h3>Califico(++IDU++, ++IDR++, calidadServ, Atencion, Precio, Higiene);</h3>

<h3>Ciudad(++CP++, Nombre, Pobl, PobCeliaco);</h3>

<h3>estaUbicado(++IDR++, ++CP++, ++puesto++);</h3>

<h3>vive_en(++IDU++, ++CP++);</h3>