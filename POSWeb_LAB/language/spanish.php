<?php
/*Spanish Language File*/

class language
{
	/*Login Start*/
	var $login='Ingresar';
    var $loginWelcomeMessage='Bienvenido(a) al POS JVMCompany. Para continuar, inicia sesion usando tu Usuario y Contrase&ntilde;a.';
    var $username='Usuario';
    var $password='Contrase&ntilde;a';
    var $go='Ingresar';
    var $login_login='Iniciar Sesion!';
	/*Login End*/


	/*Menubar Start*/
    var $home='Principal';
    var $customers='Clientes';
    var $items='Articulos';
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
    var $salesClerkHomeWelcomeMessage='POS Web Sistema de Punto de Venta! Para empezar,<br>favor seleccionar la opcion de Ventas del menu.';
    var $reportViewerHomeWelcomeMessage='POS Web Sistema de Punto de Venta! Para empezar,<br>favor seleccionar la opcion de Reportes del menu.';
    var $supervisorHomeWelcomeMessage='POS Web Sistema de Punto de Venta! Con perfil Supervisor, usted puede programar terminales de pago, autorizar anulaciones, devoluciones y descuentos de venta entre otras opciones. Para empezar,<br>puede seleccionar alguna de las siguientes opciones del sistema.';
    var $backupDatabase='Generar Backup';
    var $processSale='Hacer una Venta';
    var $addRemoveManageUsers='Administracion de Usuarios';
    var $addRemoveManageCustomers='Administracion de Clientes';
    var $addRemoveManageItems='Administracion de Articulos';
    var $viewReports='Consultas y Reportes';
    var $configureSettings='Configurar Punto de Venta';
    var $viewOnlineSupport='Soporte Tecnico en linea';
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
    var $customersWelcomeScreen='Bienvenido a la pantalla de Clientes!&nbsp;Aqui puede administrar su base de datos de sus clientes.&nbsp;Tiene que agregar un cliente antes de hacer una venta. <br>¿Que quieres hacer?';
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
    var $streetAddress='Direccion';
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
    var $itemsDispe = 'Productos Dispensados';


 	/*Manage Customers Start*/
 	var $updateCustomer='Actualizar Cliente';
    var $deleteCustomer='Borrar Cliente';
    var $searchForCustomer='Buscar Cliente (por apellido)';
    var $searchedForCustomer='Buscado por Cliente';
	var $listOfCustomers='Lista de Clientes';
	/*Manage Customers End*/


	/*Items Home Start*/
    var $itemsWelcomeScreen='Bienvenido a la pantalla de Productos.&nbsp; Aqui puede administrar Articulos, Marcas, Categorias, y Proveedores.&nbsp; Antes de hacer una venta, necesita agregar por lo menos una Categoria, una marca, un proveedor, y un articulo.&nbsp;<br>Recuerde que si su sistema POS Web se encuentra sincronizado con la plataforma TOTALeERP, usted no necesita crear los productos en este sistema, sino en cambio cargar las novedades que le sean enviadas por la central. ¿Que quiere hacer?';
    var $createNewItem='Crear un Articulo Nuevo';
    var $manageItems='Administrar Articulos';
    var $discountAnItem='Descuentos en producto';
    var $manageDiscounts='Administrar Descuentos';
    var $itemsBarcode='Hoja de Barcodes de Articulos';
    var $createBrand='Crear una Nueva Marca';
    var $manageBrands='Administar Marcas';
    var $createCategory='Crear una Categoria Nueva';
    var $manageCategories='Administar Categorias';
    var $createSupplier='Crear un Proveedor Nuevo';
    var $manageSuppliers='Administar Proveedores';
    var $invFisic='Inventario Fisico';
    var $invInfoLiqui='Informe Inventario Fisico';
	/*Items Home End*/


 	/*Items Form Start*/
    var $fraccion = 'Fra';
    var $formu = 'For';
    var $disp = 'Inv';
 	var $itemName='Nombre de Articulo';
    var $description='Descripcion';
    var $itemNumber='PLU';
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
    var $addItem='Agregar Articulo';
    var $brandsCategoriesSupplierError='Tiene que crear Marcas, Categorias, y Proveedores antes de crear un Articulo<br><a href=index.php>Regresar a Pantalla de Articulos</a>';
	var $shortdescription='Descripcion Corta';
    var $finalSellingPricePerUnit='Precio Final por Unidad';
	var $pastill = 'Pastillaje';
	var $state = 'Estado';

	/*Items Form End*/


	/*Manage Items Start*/
	var $updateItem='Actualizar Articulo';
    var $deleteItem='Borrar Articulo';
    var $searchForItem='Buscar por Articulo (Por Nombre de Articulo)';
    var $searchedForItem='Buscado por Articulo';
    var $listOfItems='Lista de Articulos';
    var $showOutOfStock='Mostrar Articulos sin Existencias';
    var $outOfStock='Articulos sin Existencias';
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
    var $categoryName='Nombre de Categoria';
    var $addCategory='Agregar Categoria';
	/*Categories Form End*/


    /*Manage Categories Start*/
	var $searchForCategory='Buscar por Categoria (Por nombre de Catagoria)';
    var $searchedForCategory='Buscado por Categoria';
    var $listOfCategories='Lista de Categorias';
    var $updateCategory='Actualizar Categoria';
    var $deleteCategory='Borrar Categoria';
    /*Manage Categories End*/


    /*Suppliers Form Start*/
    var $supplierName='Nombre de Proveedor';
    var $address='Direccion';
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
	var $reportsWelcomeMessage='Bienvenido a la pantalla de Reportes!&nbsp; Aqui puede ver reportes basados en ventas.&nbsp;<br>¿Que quiere hacer?';
    var $allCustomersReport='Ventas de Todos los Clientes';
	var $allPacientesReport='Dispensacion de Todos Los Pacientes';
    var $allEmployeesReport='Ventas de Todos los Empleados';
	var $allDisEmployeesReport='Dispensacion de Todos los Empleados';
    var $allItemsReport='Ventas de Todos los Articulos';
	var $allDisItemsReport='Dispensacion de Todos los Articulos';
    var $customerReport='Reporte de Clientes';
	var $pacienteReport='Reporte de Pacientes';
    var $dailyReport='Reporte Diario de Ventas';
	var $dailyDipReport='Reporte Diario de Dispensacion';
    var $dailyReportDispe='Reporte Diario de Dispensacion';
    var $dateRangeReport='Ventas por Rango de Fechas';
	var $dateRangeDisReport='Dispensacion por Rango de Fechas';
    var $employeeReport='Reporte de Empleados';
	var $employeeDisReport='Reporte de Empleados Dispensacion';
    var $itemReport='Reporte de Articulos';
	var $itemDispReport='Reporte de Articulos Dispensados';
    var $profitReport='Reporte de Utilidades Ventas';
    var $profitReportDispen='Reporte de Utilidades Dispensacion';
	var $cashreport='Reporte Cajero';
	var $dailyreport='Reporte Diario';
	var $closedailyreport = 'Reporte Cierre Diario';
	var $closedailyDispreport = 'Reporte Cierre Diario Dispensacion';
	var $vtas_consolid = 'Reporte Venta Consolidadas';
	var $Disp_consolid = 'Reporte Dispensacion Consolidadas';
	
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
    var $selectItem='Seleccionar Articulo';
	var $nameemp = 'Nombre Empleado';
	/*Input Needed Form End*/


    /*"All" Reports Start*/

		/*All Customers Report Start*/
		var $itemsPurchased='Articulos Comprados';
        var $itemsDispensad='Articulos Dispensados';
   		var $moneySpentBeforeTax='Compras excluyendo impuestos';
		var $exctax = 'Excluyendo Impuestos';
		var $inctax = 'Incluyendo Impuestos';
    	var $moneySpentAfterTax='Compras incluyendo impuestos';
		var $totalItemsPurchased='Total de Articulos Comprados';
		/*All Customers Report End*/

		/*All Employees Report Start*/
		var $itemsosld = 'Articulos Vendidos';
		var $totalItemsSold='Total de Articulos Vendidos';
    	var $moneySoldBeforeTax='Ventas excluyendo Impuestos';
		var $moneySoldAfterTax='Ventas incluyendo impuestos';
		/*All Employees Report End*/

		/*All Items Report Start*/
		var $numberPurchased='Numero Comprado';
   		var $subTotalForItem='Subtotal por Articulo';
        var $totalForItem='Total por Articulo';
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
    var $DisDetails = 'Detalles de la Dispensacion';
    var $saleDetails='Detalles de la Venta';
    var $saleSubTotal='Subtotal de Venta';
    var $saleTotalCost='Total,VTA';
    var $amtTendered='Valor Recibido    ';
    var $amtChange   ='Cambio';
    var $showSaleDetails='Mostrar detalles de la Venta';
    var $listOfSaleBy='Lista de Ventas por';
    var $listOfDisBy='Lista de Dispensacion por';
	var $sl = 'Ventas';
    var $listOfSalesFor='Lista de Ventas para';
    var $listOfDispeFor='Lista de Dispensacio para';
    var $listOfSalesBetween='Lista de Ventas <br>entre las fechas';
    var $listOfDispeBetween='Lista de Dispensacion <br>entre las fechas';
    var $and='y';
    var $between='entre';
    var $totalWithOutTax='Total (sin Impuestos)';
    var $totalWithTax='Total (con Impuestos)';
	var $fromMonth='Desde Mes';
    var $day='Dia';
    var $year='A&ntilde;o';
    var $toMonth='Hasta Mes';
    var $totalAmountSoldWithOutTax='Total de Ventas (sin Impuestos)';
    var $totalAmountSoldWithOutTaxDis='Total de Dispensacion (sin Impuestos)';
    var $profit='Utilidad';
    var $totalAmountSold='Total de Ventas';
    var $totalAmountSoldDis='Total de Dispensacion';
    var $totalProfit='Total de Utilidades';
    var $totalsShownBetween='Totales por ventas entre';
    var $totaldShownBetween='Totales por Dispensacion entre';
    var $totalItemCost='Total de Costo de Articulo';
	var $amount='Monto';
	var $doc_num='# Docu';
	var $entity='Entidad';
	var $auth_no='# Autoriza';
	var $comments='Comentarios';
	var $cashier='Vendedor';
	var $totalsShow='Totales por ventas para el:';
    var $totaldShow='Totales por Dispensacion para el:';
	var $porcmarg = '% Margen';
	var $valpvpcost = 'Valorizado Pvp / Costo';
	var $cost = 'Costo';
	var $margen = 'Margen';
	var $onhandqty = 'Und. En Existencia';
	var $tot_a_cost = 'Total a costo';
	var $tot_a_vta = 'Total a Vta';
	var $horatenc = '**** Horarios de Atencion ****';
	var $devolucion='Devolucion';
    var $copyRango='Reporte Tickets Ventas por Rango';
    var $selecttipoVta = 'Seleccionar tipo Ticket';
    var $costoArticulo = 'Costo por Unidad';
	/*Other Reports End*/


	/*Sales Home Start*/
	var $salesWelcomeMessage='Bienvenido a la pantalla de Ventas!&nbsp; Aqui puede crear ventas y administrar las.&nbsp; ¿Que quiere hacer?';
    var $startSale='Crear una Venta Nueva';
    var $manageSales='Administrar Ventas';
    var $manageDispe='Administrar Dispensacion';
    var $manageEvento='Administrar Eventos';
	/*Sales Home End*/


	/*Sale Interface Start*/
    var $yourShoppingCartIsEmpty='No hay nada en su Venta';
    var $addToCart='Agregar a Venta';
    var $clearSearch='Eliminar Filtro';
    var $saleComment='Comentario';
    var $addSale='Agregar Venta';
    var $quantity='Cantidad'; 
    var $remove='Borrar';
	var $cancel = 'Del';
	var $removee='Eliminar';
	var $past='Und Vta';
    var $cash='Efectivo';
	var $check='Cheque';
	var $credit='Credito';
	var $giftCertificate='Cupon';
	var $account='Cuenta Empleado';
	var $mustSelectCustomer='Tiene que seleccionar un cliente';
	var $newSale='Venta Nueva';
	var $clearSale='Borrar Venta';
	var $newSaleBarcode='Venta Nueva con scanner de Codigos de barra';
	var $scanInCustomer='Leer Codigo de Cliente ';
	var $customersuccessfully='Cliente Adicionado Satisfactoriamente';
	var $scanInItem='Leer Codigo de Articulo';
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
    var $vrtot='Total,Pagado';
	var $updat='Actualizar';
    var $dstoI = 'Dcto P.';
    var $dstoF = 'Dcto F.';
	var $dsto='Dcto';
	var $va_dsto='Val.Dsto';
	var $va_imp='Val.Imp';
	var $delet='Eliminar';
	var $customerID='Identificacion del Cliente';
	var $itemID='Codigo';
    var $typeVta = 'Tipo';
	var $totDis='Total Dispensa';
    var $tot='Total Vta';
	var $descuento='Descuento';
	var $taxa='A = 16%';
	var $taxd='D = 10%';
	var $taxe='E = 0%';
	var $cancelsaleall = 'Anular<br> venta';


	/*Sale Interface End*/


	/*Sale Receipt Start*/
	var $orderBy='Cliente';
	var $Paciente='Paciente';
    var $convenio='convenio';
    var $convenum = 'Num Conve';
    var $itemOrdered='Articulo vendido';
	var $extendedPrice='Valor';
	var $saleID='Factura Numero';
	var $orderFor='Venta por';
	var $atendio='Atendio';
	var $noart='No Articulos';

	/*Sale Receipt End*/


	/*Manage Sales Start*/
	var $searchForSale='Buscar por Venta (Por Rango de Numero de indentificacion de Venta)';
    var $searchForDistri='Buscar por Distribucion (Por Rango de Numero de indentificacion de Distribucion)';
	var $searchedForSales='Buscado Ventas dentro';
	var $highID='#ID alto ';
	var $lowID='#ID bajo ';
	var $incorrectSearchFormat='Formato de busquedad incorrecto, favor de tratar de nuevo';
	var $updateRowID='Actualizar Numero de indentificacion de fila';
	var $updateSaleID='Actualizar Numero de indentificacion de Venta';
	var $itemsInSale='Articulos en Venta';
	var $itemTotalCost='Costo Total de Articulos';
	var $updateSale='Actualizar Venta';
    var $updateDistri='Actualizar Distribucion';
    var $deleteEntireSale='Borrar Venta Entera';
	var $deleteEntireDistri='Borrar Distribucion Entera';
	var $customerName='Nombre de Cliente';
    var $customerPac='Nombre del Paciente';
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
	var $configurationWelcomeMessage='Bienvenido!&nbsp; Esta es la pantalla de Configuracion del Sistema FarMaxWeb POS Web de JVM Company Soft SAS &nbsp;
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
    var $mustBeAdmin='Tiene que ser Administrador para ver esta pagina.';
    var $mustBeReportOrAdmin='Tiene que ser Administrador o Analista para ver esta pagina.';
    var $mustBeSalesClerkOrAdmin='Tiene que ser Administrador o Cajero para ver esta pagina.';
    var $mustBeSupervisorOrAdmin='Tiene que ser Administrador o Supervisor para ver esta pagina.';
    var $youMustSelectAtLeastOneItem='Tiene que seleccionar por lo menos un Articulo';
    var $refreshAndTryAgain='Actualizar y tratar de nuevo';
	var $noActionSpecified='No hay accion especificada! No hay data agregada, cambiada, o borrada.';
	var $mustUseForm='Tienes que usar el formulario para agregar data.';
	var $forgottenFields='Falta uno o mas de los campos requeridos';
	var $passwordsDoNotMatch='Las Contrase&ntilde;as no son iguales!';
	var $logoutConfirm='Seguro que quieres salir?';
	var $usernameOrPasswordIncorrect='Usuario o Contrase&ntilde;a son incorrectos';
	var $mustEnterNumeric='Hay que insertar un valor numerico para precio, porcentaje de impuesto, y candidad.';
	var $moreThan200='Hay mas que 200 filas en ';
	var $first200Displayed='tabla, se muestra solo las primeras 200 filas. Favor usar la opcion de Buscar.';
	var $noDataInTable='No hay data en la';
	var $table='tabla';
	var $confirmDelete='Esta seguro que quieres borrar esto de la';
	var $invalidCharactor='Hay un caracter invalido en uno o mas de los campos, favor de presionar regresar y tratar de nuevo';
	var $didNotEnterID='No hay Numero de indentificacion';
	var $cantDeleteBrand='No se puede borrar esta marca porque esta en uso por algun articulo.';
	var $cantDeleteCategory='No se puede borrar esta Catagoria porque esta en uso por algun articulo.';
	var $cantDeleteCustomer='No se puede borrar este cliente porque esta en uso por algun articulo.';
	var $cantDeleteItem='No se puede borrar este articulo porque ha sido comprado por lo menos una vez.';
	var $cantDeleteSupplier='No se puede borrar este proveedor porque esta en uso por algun articulo.';
	var $cantDeleteUserLoggedIn='No se puede borrar este usuario porque actualmente esta ingresado al sistema!';
	var $cantDeleteUserEnteredSales='No se puede borrar este usuario porque ya tiene informaccion de ventas.';
	var $itemWithID='Articulo con Numero de indentificacion';
	var $isNotValid='no es valido.';
	var $customerWithID='Cliente con Numero de indentificacion';
	var $configUpdatedUnsucessfully='El archivo de configuracion no fue actualizado, favor de asegurar que se puede escribir al archivo settings.php';
	var $problemConnectingToDB='Hubo un problema al conectar a la base de datos,<br> presionar regresar y verificar su configuracion.';
	/*Error Messages End*/


    /*Success Messages Start*/
	var $upgradeMessage='Presionar ENVIAR para actualizar la base de datos a version  8.0.  Tienes que tener la version 7.0 o mas nueva para actualizar Punto de Venta.';
	var $upgradeSuccessfullMessage='La base de datos de Punto de Venta ha sido actualizada con exito a la  version 8.0, favor de borrar los directorios de upgrade y install para tu seguridad.';
	var $successfullyAdded='Has aggregado con exito a la tabla';
	var $successfullyUpdated='Has actualizado con exito a la tabla';
	var $successfullyDeletedRow='Ha borrado con exito la fila';
	var $fromThe='de la';
	var $configUpdatedSuccessfully='El archivo de configuracion fue actualizado con exito.';
	var $installSuccessfull='La instalacion de Punto de Venta fue exitosa,<br> favor de hacer clic <a href=../login.php>aqui</a> ingresar y empezar!';
	/*Success Messages End*/


	/*Installer Start*/
	var $installation='instalacion';
	var $installerWelcomeMessage='Bienvenido a la instalacion por Punto de Venta. Estamos complacidos que has escojido a JVM Company como tu socio en tecnologia para solucion de punto de venta.<br>&nbsp;&nbsp;&nbspnbsp;Para continuar el proceso de instalacion,<br>&nbsp;&nbsp;&nbsp;&nbsp; favor llenar el formato debajo y luego hacer click en el boton \'Install\'.&nbsp;';
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
    var $ticket='# Tiquete';
    var $Nformula='# Formula';
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