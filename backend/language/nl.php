<?php if(!defined('SWAMI')){die('External Access to File Denied');}

// Default actions
// ---------------------------------------------------------
msg::set(array(

	// Add
	'add'=>'toevoegen',
	'add {item}'=>'{item} toevoegen',
	'add_no_return'=>'toevoegen zonder terugkeren',
	
	// Edit
	'edit'=>'aanpassen',
	'edited'=>'aangepast',
	'edit {item}'=>'{item} aanpassen',
	
	// Change
	'change'=>'wijzigen',
	'changed'=>'gewijzigd',
	
	// Save
	'save'=>'opslaan',
	'saved'=>'succesvol opgeslagen',
	'error_on_saving'=>'fout gebeurt bij opslaan',
	'{item} saved'=>'{item} opgeslagen',
	'save_no_return'=>'opslaan zonder terugkeren',
	
	// Cancel
	'cancel'=>'annuleren',
	
	// Delete
	'delete'=>'verwijderen',
	'delete {item}'=>'{item} verwijderen',
	
	// Copy
	'copy'=>'kopiëren',
	'make_copy'=>'dupliceren',
	
	// Values
	'field'=>'veld',
	'value'=>'waarde',
	
	// Permissions
	'no_permission_for_page'=>'U heeft geen toegang tot deze pagina!',
	'no_permission_for_action'=>'U heeft geen toegang om deze actie uit te voeren!',
	
	// Extra
	'help'=>'help',
	'customer'=>'klant',
));


// Default modules
// ---------------------------------------------------------
msg::set(array(
	
	// Index
	'index'=>'overzicht',

	// Pages
	'page'=>'pagina',
	'pages'=>"pagina's",
	'blogpage'=>"blogpagina",

	// Stats
	'stats'=>'statistieken',
	'shortUrls'=>'verkorte urls',
	'visitors'=>'bezoekers',
	'downloaders'=>'downloaders',
		
	// Users
	'user'=>'gebruiker',
	'users'=>'gebruikers',

	// Galleries
	'galery'=>'galerij',
	'galeries'=>'galerijen',
	'imagegalery'=>'fotogalerij',
	'imagegaleries'=>'fotogalerijen',
	'filegalery'=>'bestandengalerij',
	'filegaleries'=>'bestandengalerijen',
	'moviegalery'=>'filmgalerij',
	'moviegaleries'=>'filmgalerijen',

	// Settings
	'setting'=>'instelling',
	'settings'=>'instellingen',
	
	// Newsletters
	'newsletters'=>'nieuwsbrieven',
	'campaigns'=>'campagnes',
	'subscribers'=>'ingeschrevenen',
	'unsubscribers'=>'uitgeschrevenen',
	'reports'=>'verslagen',
));

// Default database field names
// ---------------------------------------------------------
msg::set(array(
	
	// Names
	'name'=>'naam',
	'firstname'=>'voornaam',
	'lastname'=>'lastname',
	'title'=>'titel',
	'company'=>'bedrijf',
	
	// Date
	'created_on'=>'gemaakt op',
	'changed_on'=>'aangepast op',
	'published_on'=>'gepubliceerd op',
	'online_on'=>'online op',
	'offline_on'=>'offline op',
));