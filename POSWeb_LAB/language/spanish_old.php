<?php
/*Spanish Language File*/

class language
{
	/*Login Start*/
	var $login='Ingresar';
    var $loginWelcomeMessage='Bienvenido(a) al POS JVMCompany. Para continuar, inicia sesi&oacute;n usando tu Usuario y Contrase&ntilde;a.';
    var $username='Usuario';
    var $password='Contrase&ntilde;a';
    var $go='Ingresar!';
    var $login_login='Iniciar Sesi&oacute;n!';
	/*Login End*/


	/*Menubar Start*/
    var $home='Principal';
    var $customers='Clientes';
    var $items='Art&iacute;culos';
    var $reports='Reportes';
    var $sale='Venta';
    var $salesNow='Facturar';
    var $config='Configurar';
    var $poweredBy='Lisenced by';
    var $welcome='Bienvenido';
    var $logout='Salir';
	/*Menubar End*/


	/*Home Start*/
	var $welcomeTo='Bienvenido a ';
	var $adminHomeWelcomeMessage='FarMaxWeb POS Web, Sistema de Punto de Venta.&nbsp; Esta actualmente ingresado <br>con perfil de administrador.<br><br> Con perfil Administrador, puede ir a cualquier parte del sistema y ejecutar cualquier opcion del menu superior.&nbsp;<br>Tambien puede seleccionar cualquiera de las siguientes opciones:';
    var $salesClerkHomeWelcomeMessage='POS Web Sistema de Punto de Venta! Para empezar,<br>favor seleccionar la opci&oacute;n de Ventas del men&uacute;.';
    var $reportViewerHomeWelcomeMessage='POS Web Sistema de Punto de Venta! Para empezar,<br>favor seleccionar la opci&oacute;n de Reportes del men&uacute;.';
    var $supervisorHomeWelcomeMessage='POS Web Sistema de Punto de Venta! Con perfil Supervisor, usted puede programar terminales de pago, autorizar anulaciones, devoluciones y descuentos de venta entre otras opciones. Para empezar,<br>puede seleccionar alguna de las siguientes opciones del sistema.';
    var $backupDatabase='Generar Backup';
    var $processSale='Hacer una Venta';
    var $addRemoveManageUsers='Administracion de Usuarios';
    var $addRemoveManageCustomers='Administracion de Clientes';
    var $addRemoveManageItems='Administracion de Art&iacute;culos';
    var $viewReports='Consultas y Reportes';
    var $configureSettings='Configurar Punto de Venta';
    var $viewOnlineSupport='Soporte T&eacute;cnico en l&iacute;nea';
	/*Home End*/


	/*Users Home Start*/
	var $createUser='Crear un Usuario Nuevo';
    var $manageUsers='Administrar Usuarios';
    /*Users Home End*/


	/*Users Form Start*/
	var $addUser='Agregar Usuario';
	var $usedInLogin='usado al ingresar';
    var $type='Tipo';
    var $admin='Admin';
    var $salesClerk='Cajero';
    var $reportViewer='Analista';
    var $supervisor='Supervisor';
    var $confirmPassword='Confirmar Contrase&ntilde;a';
	/*Users Form End*/


	/*Manage Users Start*/
	var $searchForUser='Buscar por Usuario (Por Nombre de Usuario)';
    var $searchedForUser='Buscado por Nombre de Usuario';
	var $deleteUser='Borrar Usuario';
    var $updateUser='Actualizar Usuario';
	/*Manage Users End*/


	/*Customers Home Start*/
    var $customersWelcomeScreen='Bienvenido a la pantalla de Clientes!&nbsp;Aqui puede administrar su base de datos de sus clientes.&nbsp;Tiene que agregar un cliente antes de hacer una venta. <br>¿Qu&eacute; quieres hacer?';
    var $createNewCustomer='Crear un Cliente nuevo';
    var $manageCustomers='Administar Clientes';
    var $customersBarcode='Hoja de Barcodes de Clientes';
	/*Customers Home End*/


 	/*Customers Form Start*/
 	var $addCustomer='Agregar Cliente';
    var $firstName='Nombres';
    var $lastName='Apellidos';
    var $accountNumber='Cedula o Nit';
    var $phoneNumber='Tel';
    var $email='eMail';
    var $streetAddress='Direcci&oacute;n';
    var $commentsOrOther='Comentarios/Otro';
	var $sucursal='Sucursal';
	var $datecustom = 'Datos Cliente';
    var $posologia = 'Posologia o Dosificacion';
 	var $medicamento ='Medicamento';
	var $dosis = 'Dosis';
	var $tomar = 'Tomar';
	var $cada = 'Cada';
	var $durante = 'Durante';
	var $dias = 'Dias';
	var $datosmedico = 'Datos Medico';
	var $direccioncons = 'Direccion Cons.';
	var $itemssales = 'Productos Vendidos';


 	/*Manage Customers Start*/
 	var $updateCustomer='Actualizar Cliente';
    var $deleteCustomer='Borrar Cliente';
    var $searchForCustomer='Buscar Cliente (por apellido)';
    var $searchedForCustomer='Buscado por Cliente';
	var $listOfCustomers='Lista de Clientes';
	/*Manage Customers End*/


	/*Items Home Start*/
    var $itemsWelcomeScreen='Bienvenido a la pantalla de Productos.&nbsp; Aqui puede administrar Art&iacute;culos, Marcas, Categor&iacute;as, y Proveedores.&nbsp; Antes de hacer una venta, necesita agregar por lo menos una Categor&iacute;a, una marca, un proveedor, y un art&iacute;culo.&nbsp;<br>Recuerde que si su sistema POS Web se encuentra sincronizado con la plataforma TOTALeERP, usted no necesita crear los productos en este sistema, sino en cambio cargar las novedades que le sean enviadas por la central. ¿Qu&eacute; quiere hacer?';
    var $createNewItem='Crear un Art&iacute;culo Nuevo';
    var $manageItems='Administrar Art&iacute;culos';
    var $discountAnItem='Descuentos en producto';
    var $manageDiscounts='Administrar Descuentos';
    var $itemsBarcode='Hoja de Barcodes de Art&iacute;culos';
    var $createBrand='Crear una Nueva Marca';
    var $manageBrands='Administar Marcas';
    var $createCategory='Crear una Categor&iacute;a Nueva';
    var $manageCategories='Administar Categor&iacute;as';
    var $createSupplier='Crear un Proveedor Nuevo';
    var $manageSuppliers='Administar Proveedores';
    var $invFisic='Inventario Fisico';
    var $invInfoLiqui='Informe Inventario Fisico';
	/*Items Home End*/


 	/*Items Form Start*/
    var $fraccion = 'Fra';
    var $formu = 'For';
    var $disp = 'Inv';
 	var $itemName='Nombre de Art&iacute;culo';
    var $description='Descripcion';
    var $itemNumber='N&uacute;mero de Art&iacute;culo';
    var $brand='Marca';
    var $category='Categoria';
    var $supplier='Proveedor';
    var $buyingPrice='Costo de Compra';
    var $sellingPrice='Precio de Venta';
    var $tax='Impuesto de Vta';
    var $supplierCatalogue='Codigo Proveedor';
    var $quantityStock='Cantidad en Existencia';
    var $reorderLevel='Cantidad Reorden';
    var $users='Usuarios';
    var $itemsInBoldRequired='Se Requieren los Campos en Negrita';
    var $update='Actualizar';
    var $delete='Borrar';
    var $addItem='Agregar Art&iacute;culo';
    var $brandsCategoriesSupplierError='Tiene que crear Marcas, Categor&iacute;as, y Proveedores antes de crear un Art&iacute;culo<br><a href=index.php>Regresar a Pantalla de Art&iacute;culos</a>';
	var $shortdescription='Descripcion Corta';
    var $finalSellingPricePerUnit='Precio Final por Unidad';
	var $pastill = 'Pastillaje';
	var $state = 'Estado';

	/*Items Form End*/


	/*Manage Items Start*/
	var $updateItem='Actualizar Art&iacute;culo';
    var $deleteItem='Borrar Art&iacute;culo';
    var $searchForItem='Buscar por Art&iacute;culo (Por Nombre de Art&iacute;culo)';
    var $searchedForItem='Buscado por Art&iacute;culo';
    var $listOfItems='Lista de Art&iacute;culos';
    var $showOutOfStock='Mostrar Art&iacute;culos sin Existencias';
    var $outOfStock='Art&iacute;culos sin Existencias';
	/*Manage Items End*/


    /*Brands Form Start*/
    var $brandName='Nombre de Marca';
    var $addBrand='Agregar Marca';
	/*Brands Form End*/


    /*Manage Brands Start*/
    var $searchForBrand='Buscar por Marca (Por nombre de Marca)';
    var $searchedForBrand='Buscado por Marca' ;
    var $listOfBrands='Lista de Marcas';
    var $updateBrand='Actualizar Marca';
    var $deleteBrand='Borrar Marca';
	/*Manage Brands End*/


    /*Categories Form Start*/
    var $categoryName='Nombre de Categor&iacute;a';
    var $addCategory='Agregar Categoria';
	/*Categories Form End*/


    /*Manage Categories Start*/
	var $searchForCategory='Buscar por Categoria (Por nombre de Catagor&iacute;a)';
    var $searchedForCategory='Buscado por Categoria';
    var $listOfCategories='Lista de Categorias';
    var $updateCategory='Actualizar Categoria';
    var $deleteCategory='Borrar Categoria';
    /*Manage Categories End*/


    /*Suppliers Form Start*/
    var $supplierName='Nombre de Proveedor';
    var $address='Direcci&oacute;n';
    var $contact='Contacto';
    var $other='Mensaje Uno';
	var $vble='Variable';

	/*Suppliers Form End*/


    /*Manage Suppliers Start*/
    var $listOfSuppliers='Lista de Proveedores';
    var $searchForSupplier='Buscar por Proveedor (por nombre de Proveedor)';
    var $searchedForSupplier='Buscado por Proveedor';
    var $addSupplier='Agregar Proveedor';
    var $updateSupplier='Actualizar Proveedor';
    var $deleteSupplier='Borrar Proveedor';
    /*Manage Suppliers End*/


	/*Reports Home Start*/
	var $reportsWelcomeMessage='Bienvenido a la pantalla de Reportes!&nbsp; Aqui puede ver reportes basados en ventas.&nbsp;<br>¿Qu&eacute; quiere hacer?';
    var $allCustomersReport='Ventas de Todos los Clientes';
    var $allEmployeesReport='Ventas de Todos los Empleados';
    var $allItemsReport='Ventas de Todos los Art&iacute;culos';
    var $customerReport='Reporte de Clientes';
    var $dailyReport='Reporte Diario de Ventas';
    var $dailyReportDispe='Reporte Diario de Dispensaci&oacute;n';
    var $dateRangeReport='Ventas por Rango de Fechas';
    var $employeeReport='Reporte de Empleados';
    var $itemReport='Reporte de Art&iacute;culos';
    var $profitReport='Reporte de Utilidades';
	var $cashreport='Reporte Cajero';
	var $dailyreport='Reporte Diario';
	var $closedailyreport = 'Reporte Cierre Diario';
	var $vtas_consolid = 'Reporte Venta Consolidadas';
	/*Reports Home End*/


	/*Input Needed Form Start*/
	var $inputNeeded='Input needed for';
    var $dateRange='Rango de Fechas';
    var $today='Hoy';
    var $yesterday='Ayer';
    var $last7days='Ultima Semana';
    var $lastMonth='Ultimo Mes';
    var $thisMonth='Mes Actual';
    var $thisYear='A&ntilde;o Actual';
    var $allTime='Todo el tiempo';
    var $findCustomer='Filtrar Cliente';
    var $selectCustomer='Seleccionar Cliente';
    var $findEmployee='Buscar Empleado';
    var $selectEmployee='Seleccionar Empleado';
    var $findItem='Filtrar Producto';
    var $selectItem='Seleccionar Art&iacute;culo';
	var $nameemp = 'Nombre Empleado';
	/*Input Needed Form End*/


    /*"All" Reports Start*/

		/*All Customers Report Start*/
		var $itemsPurchased='Art&iacute;culos Comprados';
        var $itemsDispensad='Art&iacute;culos Dispensados';
   		var $moneySpentBeforeTax='Compras excluyendo impuestos';
		var $exctax = 'Excluyendo Impuestos';
		var $inctax = 'Incluyendo Impuestos';
    	var $moneySpentAfterTax='Compras incluyendo impuestos';
		var $totalItemsPurchased='Total de Art&iacute;culos Comprados';
		/*All Customers Report End*/

		/*All Employees Report Start*/
		var $itemsosld = 'Articulos Vendidos';
		var $totalItemsSold='Total de Art&iacute;culos Vendidos';
    	var $moneySoldBeforeTax='Ventas excluyendo Impuestos';
		var $moneySoldAfterTax='Ventas incluyendo impuestos';
		/*All Employees Report End*/

		/*All Items Report Start*/
		var $numberPurchased='N&uacute;mero Comprado';
   		var $subTotalForItem='Subtotal por Art&iacute;culo';
        var $totalForItem='Total por Art&iacute;culo';
		/*All Items Report End*/

	/*"All" Reports End*/


	/*Other Reports Start*/
    var $ticketnum = 'Factura No.';
    var $city='Ciudad';
    var $hoursec = 'Hora';
	var $dettax='INFORMACION IMPTOS';
	var $tar='Tarifa';
	var $buy='Compra';
	var $sales='Venta';
	var $base_imp='Base / Imp';
	var $vlriva='Vlr Iva';
	var $paidWithdet='Detalle Pago Cliente';
	var $asteric='--------------------------------------';
	var $paidWith='M. Pago';
	var $paidwithsale = 'Ventas por Medio de Pago ';
    var $soldBy='Vendido Por';
    var $DisBy='Dispensado Por';
    var $DisDetails = 'Detalles de la Dispensaci&oacute;n';
    var $saleDetails='Detalles de la Venta';
    var $saleSubTotal='Subtotal de Venta';
    var $saleTotalCost='Total de la Venta';
    var $amtTendered='Valor Recibido    ';
    var $amtChange   ='Cambio al Cliente';
    var $showSaleDetails='Mostrar detalles de la Venta';
    var $listOfSaleBy='Lista de Ventas por';
	var $sl = 'Ventas';
    var $listOfSalesFor='Lista de Ventas para';
    var $listOfDispeFor='Lista de Dispensaci&oacute; para';
    var $listOfSalesBetween='Lista de Ventas <br>entre las fechas';
    var $and='y';
    var $between='entre';
    var $totalWithOutTax='Total (sin Impuestos)';
    var $totalWithTax='Total (con Impuestos)';
	var $fromMonth='Desde Mes';
    var $day='Dia';
    var $year='A&ntilde;o';
    var $toMonth='Hasta Mes';
    var $totalAmountSoldWithOutTax='Total de Ventas (sin Impuestos)';
    var $profit='Utilidad';
    var $totalAmountSold='Total de Ventas';
    var $totalProfit='Total de Utilidades';
    var $totalsShownBetween='Totales por ventas entre';
    var $totalItemCost='Total de Costo de Art&iacute;culo';
	var $amount='Monto';
	var $doc_num='# Docu';
	var $entity='Entidad';
	var $auth_no='# Autoriza';
	var $comments='Comentarios';
	var $cashier='Vendedor';
	var $totalsShow='Totales por ventas para el:';
	var $porcmarg = '% Margen';
	var $valpvpcost = 'Valorizado Pvp / Costo';
	var $cost = 'Costo';
	var $margen = 'Margen';
	var $onhandqty = 'Und. En Existencia';
	var $tot_a_cost = 'Total a costo';
	var $tot_a_vta = 'Total a Vta';
	var $horatenc = '**** Horarios de Atencion ****';
	var $devolucion='Devolucion';
	/*Other Reports End*/


	/*Sales Home Start*/
	var $salesWelcomeMessage='Bienvenido a la pantalla de Ventas!&nbsp; Aqui puede crear ventas y administrar las.&nbsp; ¿Qu&eacute; quiere hacer?';
    var $startSale='Crear una Venta Nueva';
    var $manageSales='Administar Ventas';
	/*Sales Home End*/


	/*Sale Interface Start*/
    var $yourShoppingCartIsEmpty='No hay nada en su Venta';
    var $addToCart='Agregar a Venta';
    var $clearSearch='Eliminar Filtro';
    var $saleComment='Comentario';
    var $addSale='Agregar Venta';
    var $quantity='Cantidad';
    var $remove='Borrar';
	var $cancel = 'Anular';
	var $removee='Eliminar';
	var $past='Und Vta';
    var $cash='Efectivo';
	var $check='Cheque';
	var $credit='Credito';
	var $giftCertificate='Cup&oacute;n';
	var $account='Cuenta Empleado';
	var $mustSelectCustomer='Tiene que seleccionar un cliente';
	var $newSale='Venta Nueva';
	var $clearSale='Borrar Venta';
	var $newSaleBarcode='Venta Nueva con scanner de C&oacute;digos de barra';
	var $scanInCustomer='Leer C&oacute;digo de Cliente ';
	var $customersuccessfully='Cliente Adicionado Satisfactoriamente';
	var $scanInItem='Leer C&oacute;digo de Articulo';
	var $shoppingCart='Factura';
	var $sentencelong='DESCRIPCION';
	var $priceuni='PRECIO';
	var $price_sindsto = 'Pr.Unit';
	var $price_net = 'Pr.Neto';
	var $price_unt = 'Pr.Vta';
	var $tax_tit='Imp';
	var $qty_tit='Cant';
    var $qty_for='Form';
    var $qty_des='Desp';
	var $tqty_tit='T.Cant';
    var $vrtot='Total Pagado';
	var $updat='Actualizar';
    var $dstoI = 'Dcto P.';
    var $dstoF = 'Dcto F.';
	var $dsto='Dcto';
	var $va_dsto='Val.Dsto';
	var $va_imp='Val.Imp';
	var $delet='Eliminar';
	var $customerID='Identificaci&oacute;n del Cliente';
	var $itemID='Codigo';
    var $typeVta = 'Tipo';
	var $totDis='Total Dispensa';
    var $tot='Total Vta';
	var $descuento='Descuento';
	var $taxa='A = 16%';
	var $taxd='D = 10%';
	var $taxe='E = 0%';
	var $cancelsaleall = 'Anular venta';


	/*Sale Interface End*/


	/*Sale Receipt Start*/
	var $orderBy='Cliente';
	var $Paciente='Paciente';
    var $convenio='convenio';
    var $convenum = 'Num Conve';
    var $itemOrdered='Art&iacute;culo vendido';
	var $extendedPrice='Valor';
	var $saleID='Factura N&uacute;mero';
	var $orderFor='Venta por';
	var $atendio='Atendio';
	var $noart='No Articulos';

	/*Sale Receipt End*/


	/*Manage Sales Start*/
	var $searchForSale='Buscar por Venta (Por Rango de N&uacute;mero de indentificaci&oacute;n de Venta)';
	var $searchedForSales='Buscado Ventas dentro';
	var $highID='#ID alto ';
	var $lowID='#ID bajo ';
	var $incorrectSearchFormat='Formato de busquedad incorrecto, favor de tratar de nuevo';
	var $updateRowID='Actualizar N&uacute;mero de indentificaci&oacute;n de fila';
	var $updateSaleID='Actualizar N&uacute;mero de indentificaci&oacute;n de Venta';
	var $itemsInSale='Art&iacute;culos en Venta';
	var $itemTotalCost='Costo Total de Art&iacute;culos';
	var $updateSale='Actualizar Venta';
	var $deleteEntireSale='Borrar Venta Entera';
	var $customerName='Nombre de Cliente';
	var $unitPrice='Precio por Unidad';
	var $pvc = 'P V C';  // precio venta cadena
	var $porcdesto = '% Dsto';
	var $vlrdsto = 'Vlr Dsto';
	var $vlrcondsto = 'Vlr con  Dsto';
	var $porciva = '% Iva';
	var $pvp = 'P V P'; // precio venta publico
	var $cant = 'Cant';
	var $vlrtot = 'Vlr Tot';
	/*Manage Sales End*/


	/*Config Start*/
	var $configurationWelcomeMessage='Bienvenido!&nbsp; Esta es la pantalla de Configuraci&oacute;n del Sistema FarMaxWeb POS Web de JVM Company Soft SAS &nbsp;
Aqui puede definir y modificar informacion de la empresa, temas y parametros del sistema entre otras opciones.&nbsp;Los campos en negrita son requeridos.';
    var $companyName='Nombre de la Empresa';
	var $companynit='Nro.Identificacion Tributaria';
	var $nit='N I T';
    var $fax='Fax';
    var $website='Sitio de Internet';
    var $theme='Template';
    var $taxRate='IVA';
    var $inPercent='en Porcentaje';
    var $currencySymbol='Symbolo de Moneda';
    var $barCodeMode='Modo de Identificacion';
    var $language='Idioma';
    var $res_fact='Resolucion facturacion';
    var $fact_desde='Facturacion desde Nro.';
    var $fac_hasta='Facturacion hasta Nro.';
    var $pref_fac='Prefijo Facturacion';
    var $start_balance='Valor Base';
    var $turnjournal='Duracion Turno (Hrs)';
	var $desdeno = 'Desde Nro.';
	var $hastano = 'Hasta Nro.';
	var $desdefact = 'Desde factura #';
	var $tckcodetype = 'Codigo en ticket';
    var $footer1 = 'Pie de ticket 1	';
	var $footer2 = 'Pie de ticket 2	';
	var $footer3 = 'Pie de ticket 3	';
	var $header1 = 'Encabezado ticket 1';
	var $header2 = 'Encabezado ticket 2';
	var $header3 = 'Encabezado ticket 3';
	var $promomgnt = 'Maneja Promociones?';
	var $dsctoprod = 'Maneja Descuentos por Producto?';
	var $dsctoglo = 'Maneja Descuentos Globales?';
	var $dsctovol = 'Maneja Descuentos por Volumen?';
	var $aproxprice = 'Maneja Aproximacion de Precio?';
	var $aproxpay = 'Maneja redondeo en Medios de Pago?';
	var $especialmov = 'Maneja Movimientos Especiales?';
	var $creditsales = 'Maneja Ventas a Credito?';
	var $prepaysales = 'Maneja Anticipo en Ventas?';
	var $quotesales = 'Maneja Generacion de cotizaciones?';
	var $fracprod = 'Maneja Fraccionamiento de Producto?';
	var $domisales = 'Maneja Servicio de Domicilios?';
	var $salesman = 'Solicita Vendedor al Registrar?';
	var $opencero = 'Permite Apertura del Cajon en ceros?';
	var $supervisorkey = 'Exige Clave del Supervisor?';
	var $changeprice = 'Obliga Precio al Vender?';
	var $validatecmt = 'Realiza Validacion de Documentos?';
	var $admonprinter = 'Ruta de Impresora Administrativa';
	var $limitrecordview = 'Limite de registros';
	var $ciiu = 'CIIU';
	var $tarifa_ciiu = 'Tarifa CIIU';
	var $tip_contrib = 'Tipo Contribuyente';
	var $autoretenedor = 'Autoretenedor';
	var $regnoventa = 'Agotado';
	var $search_product_combo = 'Permite la busqueda x combo para productos';

	/*Config End*/


	/*Error Messages Start*/
	var $youDoNotHaveAnyDataInThe='No hay data adentro de ';
    var $attemptedSecurityBreech='Falla de Seguridad, no tiene autorizacion.';
    var $mustBeAdmin='Tiene que ser Administrador para ver esta p&aacute;gina.';
    var $mustBeReportOrAdmin='Tiene que ser Administrador o Analista para ver esta p&aacute;gina.';
    var $mustBeSalesClerkOrAdmin='Tiene que ser Administrador o Cajero para ver esta p&aacute;gina.';
    var $mustBeSupervisorOrAdmin='Tiene que ser Administrador o Supervisor para ver esta p&aacute;gina.';
    var $youMustSelectAtLeastOneItem='Tiene que seleccionar por lo menos un Art&iacute;culo';
    var $refreshAndTryAgain='Actualizar y tratar de nuevo';
	var $noActionSpecified='No hay acci&oacute;n especificada! No hay data agregada, cambiada, o borrada.';
	var $mustUseForm='Tienes que usar el formulario para agregar data.';
	var $forgottenFields='Falta uno o mas de los campos requeridos';
	var $passwordsDoNotMatch='Las Contrase&ntilde;as no son iguales!';
	var $logoutConfirm='Seguro que quieres salir?';
	var $usernameOrPasswordIncorrect='Usuario o Contrase&ntilde;a son incorrectos';
	var $mustEnterNumeric='Hay que insertar un valor num&eacute;rico para precio, porcentaje de impuesto, y candidad.';
	var $moreThan200='Hay mas que 200 filas en ';
	var $first200Displayed='tabla, se muestra solo las primeras 200 filas. Favor usar la opcion de Buscar.';
	var $noDataInTable='No hay data en la';
	var $table='tabla';
	var $confirmDelete='Esta seguro que quieres borrar esto de la';
	var $invalidCharactor='Hay un car&aacute;cter invalido en uno o mas de los campos, favor de presionar regresar y tratar de nuevo';
	var $didNotEnterID='No hay N&uacute;mero de indentificaci&oacute;n';
	var $cantDeleteBrand='No se puede borrar esta marca porque esta en uso por algun art&iacute;culo.';
	var $cantDeleteCategory='No se puede borrar esta Catagor&iacute;a porque esta en uso por algun art&iacute;culo.';
	var $cantDeleteCustomer='No se puede borrar este cliente porque esta en uso por algun art&iacute;culo.';
	var $cantDeleteItem='No se puede borrar este art&iacute;culo porque ha sido comprado por lo menos una vez.';
	var $cantDeleteSupplier='No se puede borrar este proveedor porque esta en uso por algun art&iacute;culo.';
	var $cantDeleteUserLoggedIn='No se puede borrar este usuario porque actualmente esta ingresado al sistema!';
	var $cantDeleteUserEnteredSales='No se puede borrar este usuario porque ya tiene informaccion de ventas.';
	var $itemWithID='Art&iacute;culo con N&uacute;mero de indentificaci&oacute;n';
	var $isNotValid='no es v&aacute;lido.';
	var $customerWithID='Cliente con N&uacute;mero de indentificaci&oacute;n';
	var $configUpdatedUnsucessfully='El archivo de configuraci&oacute;n no fue actualizado, favor de asegurar que se puede escribir al archivo settings.php';
	var $problemConnectingToDB='Hubo un problema al conectar a la base de datos,<br> presionar regresar y verificar su configuraci&oacute;n.';
	/*Error Messages End*/


    /*Success Messages Start*/
	var $upgradeMessage='Presionar ENVIAR para actualizar la base de datos a version  8.0.  Tienes que tener la version 7.0 o m&aacute;s nueva para actualizar Punto de Venta.';
	var $upgradeSuccessfullMessage='La base de datos de Punto de Venta ha sido actualizada con exito a la  version 8.0, favor de borrar los directorios de upgrade y install para tu seguridad.';
	var $successfullyAdded='Has aggregado con exito a la tabla';
	var $successfullyUpdated='Has actualizado con exito a la tabla';
	var $successfullyDeletedRow='Ha borrado con exito la fila';
	var $fromThe='de la';
	var $configUpdatedSuccessfully='El archivo de configuraci&oacute;n fue actualizado con exito.';
	var $installSuccessfull='La instalaci&oacute;n de Punto de Venta fue exitosa,<br> favor de hacer clic <a href=../login.php>aqui</a> ingresar y empezar!';
	/*Success Messages End*/


	/*Installer Start*/
	var $installation='instalaci&oacute;n';
	var $installerWelcomeMessage='Bienvenido a la instalaci&oacute;n por Punto de Venta. Estamos complacidos que has escojido a JVM Company como tu socio en tecnologia para solucion de punto de venta.<br>&nbsp;&nbsp;&nbspnbsp;Para continuar el proceso de instalaci&oacute;n,<br>&nbsp;&nbsp;&nbsp;&nbsp; favor llenar el formato debajo y luego hacer click en el bot&oacute;n \'Install\'.&nbsp;';
	var $databaseServer='Servidor de base de datos';
	var $databaseName='Nombre de base de datos';
	var $databaseUsername='Usuario de base de datos';
	var $databasePassword='Contrase&ntilde;a de base de datos';
	var $mustExist='tiene que existir';
	var $defaultTaxRate='Impuesto predeterminado';
	var $tablePrefix='Prefijo de Tabla';
	var $whenYouFirstLogIn='Importante, cuando ingrese la primera vez su usuario es';
	var $yourPasswordIs='su contrase&ntilde;a es';
	var $install='Instalar';
	var $serious='Serio';
	var $bigBlue='Big Blue';
	var $percent='Porcentaje';
	var $sigporc = '%';
	/*Installer End*/


	/*Generic Start*/
    var $name='Nombre';
    var $customer='Cliente';
    var $employee='Empleado';
    var $date='Fecha';
    var $rowID='ID Fila';
    var $field='Campo';
	var $data='Data';
	var $quantityPurchased='Cantidad Comprada';
    var $quantityDispensa='Cantidad Dispensada';
    var $quantityFormula = 'Cantidad Formulada';
	var $listOf='Lista de';
	var $wo='sin';//without
	var $invoicenumber = '# Factura';
	var $simbolnumb = '#';
	/*Generic End*/

	/* Administrador metodos de pago*/
	var $mediosp = "MEDIOS DE PAGO";
    var $mediospdetail = " DETALLE MEDIO DE PAGO";
	var $medp = 'Medio de Pago';
	var $acepch = 'Acepta Cambio?';
	var $actinac = 'Activo';
	var $actinact = 'Activar / Inactivar';
	var $addmedio = 'Adicionar Medio de pago';
	var $detail = 'Detalles';
	var $adddetailmed = 'Adicionar detalle';
	var $namedetail = 'Nombre detalle';

	/**/

}

?>