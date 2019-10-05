<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	require_once(dirname(__FILE__) . '/Total-Soft-Pricing.php');
	require_once(dirname(__FILE__) . '/Total-Soft-Calendar-Data.php');
	global $wpdb;

	wp_enqueue_media();
	wp_enqueue_script( 'custom-header' );
	add_filter( 'upload_size_limit', 'PBP_increase_upload' );
	function PBP_increase_upload(  )
	{
		return 20480000; // 20MB
	}

	$table_name3  = $wpdb->prefix . "totalsoft_cal_events";
	$table_name4  = $wpdb->prefix . "totalsoft_cal_types";
	$table_name6  = $wpdb->prefix . "totalsoft_cal_events_p2";
	$table_name10 = $wpdb->prefix . "totalsoft_cal_events_p3";

	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if(check_admin_referer( 'edit-menu_', 'TS_CalEv_Nonce' ))
		{
			if(isset($_POST['Total_Soft_Cal_OrderEv']))
			{
				$TotalSoft_Cal_Ev_Count = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d order by id",0));
				$TotalSoft_Cal_Ev_Count1 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name6 WHERE id>%d order by id",0));
				$TotalSoft_Cal_Ev_Count2 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name10 WHERE id>%d order by id",0));

				$Total_SoftCal_Ev_New_Or = array();
				for($i = 1; $i <= count($TotalSoft_Cal_Ev_Count); $i++)
				{
					array_push($Total_SoftCal_Ev_New_Or, sanitize_text_field($_POST['TSoft_Cal_Move_ID_' . $i]));
				}

				for($i = 0; $i < count($TotalSoft_Cal_Ev_Count); $i++)
				{
					for($j = 0; $j < count($TotalSoft_Cal_Ev_Count); $j++)
					{
						if($TotalSoft_Cal_Ev_Count[$i]->id == $Total_SoftCal_Ev_New_Or[$j])
						{
							$wpdb->query($wpdb->prepare("UPDATE $table_name3 set TotalSoftCal_EvName = %s, TotalSoftCal_EvCal = %s, TotalSoftCal_EvStartDate = %s, TotalSoftCal_EvEndDate = %s, TotalSoftCal_EvURL = %s, TotalSoftCal_EvURLNewTab = %s, TotalSoftCal_EvStartTime = %s, TotalSoftCal_EvEndTime = %s, TotalSoftCal_EvColor = %s WHERE id = %d", $TotalSoft_Cal_Ev_Count[$i]->TotalSoftCal_EvName, $TotalSoft_Cal_Ev_Count[$i]->TotalSoftCal_EvCal, $TotalSoft_Cal_Ev_Count[$i]->TotalSoftCal_EvStartDate, $TotalSoft_Cal_Ev_Count[$i]->TotalSoftCal_EvEndDate, $TotalSoft_Cal_Ev_Count[$i]->TotalSoftCal_EvURL, $TotalSoft_Cal_Ev_Count[$i]->TotalSoftCal_EvURLNewTab, $TotalSoft_Cal_Ev_Count[$i]->TotalSoftCal_EvStartTime, $TotalSoft_Cal_Ev_Count[$i]->TotalSoftCal_EvEndTime, $TotalSoft_Cal_Ev_Count[$i]->TotalSoftCal_EvColor, $TotalSoft_Cal_Ev_Count[$j]->id));
							$wpdb->query($wpdb->prepare("UPDATE $table_name6 set TotalSoftCal_EvDesc = %s, TotalSoftCal_EvImg = %s, TotalSoftCal_EvVid_Src = %s, TotalSoftCal_EvVid_Iframe = %s WHERE TotalSoftCal_EvCal = %s", $TotalSoft_Cal_Ev_Count1[$i]->TotalSoftCal_EvDesc, $TotalSoft_Cal_Ev_Count1[$i]->TotalSoftCal_EvImg, $TotalSoft_Cal_Ev_Count1[$i]->TotalSoftCal_EvVid_Src, $TotalSoft_Cal_Ev_Count1[$i]->TotalSoftCal_EvVid_Iframe, $TotalSoft_Cal_Ev_Count[$j]->id));
							$wpdb->query($wpdb->prepare("UPDATE $table_name10 set TotalSoftCal_EvRec = %s WHERE TotalSoftCal_EvCal = %s", $TotalSoft_Cal_Ev_Count2[$i]->TotalSoftCal_EvRec, $TotalSoft_Cal_Ev_Count[$j]->id));
						}
					}
				}
			}
			else
			{
				$TotalSoftCal_EvName = str_replace("\&","&", sanitize_text_field(esc_html($_POST['TotalSoftCal_EvName'])));
				$TotalSoftCal_EvCal = sanitize_text_field($_POST['TotalSoftCal_EvCal']);
				$TotalSoftCal_EvStartDate = sanitize_text_field($_POST['TotalSoftCal_EvStartDate']);
				$TotalSoftCal_EvEndDate = sanitize_text_field($_POST['TotalSoftCal_EvEndDate']);
				$TotalSoftCal_EvURL = sanitize_text_field($_POST['TotalSoftCal_EvURL']);
				$TotalSoftCal_EvURLNewTab = sanitize_text_field($_POST['TotalSoftCal_EvURLNewTab']);
				$TotalSoftCal_EvStartTime = sanitize_text_field($_POST['TotalSoftCal_EvStartTime']);
				$TotalSoftCal_EvEndTime = sanitize_text_field($_POST['TotalSoftCal_EvEndTime']);
				$TotalSoftCal_EvColor = sanitize_text_field($_POST['TotalSoftCal_EvColor']);
				$TotalSoftCal_EvDesc = str_replace("\&","&", sanitize_text_field(esc_html($_POST['TotalSoftCal_EvDesc_1'])));
				$TotalSoftCal_EvImg = sanitize_text_field($_POST['TotalSoftCalendar_URL_Image_2']);
				$TotalSoftCal_EvVid_Src = sanitize_text_field($_POST['TotalSoftCalendar_URL_Video_2']);
				$TotalSoftCal_EvVid_Iframe = sanitize_text_field($_POST['TotalSoftCalendar_URL_Video_1']);
				$TotalSoftCal_EvRec = 'none';

				if(isset($_POST['Total_Soft_Cal_SaveEv']))
				{
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, TotalSoftCal_EvName, TotalSoftCal_EvCal, TotalSoftCal_EvStartDate, TotalSoftCal_EvEndDate, TotalSoftCal_EvURL, TotalSoftCal_EvURLNewTab, TotalSoftCal_EvStartTime, TotalSoftCal_EvEndTime, TotalSoftCal_EvColor) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $TotalSoftCal_EvName, $TotalSoftCal_EvCal, $TotalSoftCal_EvStartDate, $TotalSoftCal_EvEndDate, $TotalSoftCal_EvURL, $TotalSoftCal_EvURLNewTab, $TotalSoftCal_EvStartTime, $TotalSoftCal_EvEndTime, $TotalSoftCal_EvColor));

					$TotalSoftCalEvent=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d order by id desc limit 1",0));

					$wpdb->query($wpdb->prepare("INSERT INTO $table_name6 (id, TotalSoftCal_EvDesc, TotalSoftCal_EvImg, TotalSoftCal_EvVid_Src, TotalSoftCal_EvVid_Iframe, TotalSoftCal_EvCal) VALUES (%d, %s, %s, %s, %s, %s)", '', $TotalSoftCal_EvDesc, $TotalSoftCal_EvImg, $TotalSoftCal_EvVid_Src, $TotalSoftCal_EvVid_Iframe, $TotalSoftCalEvent[0]->id));
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name10 (id, TotalSoftCal_EvCal, TotalSoftCal_EvRec) VALUES (%d, %s, %s)", '', $TotalSoftCalEvent[0]->id, $TotalSoftCal_EvRec));
				}
				else if(isset($_POST['Total_Soft_Cal_UpdateEv']))
				{
					$Total_SoftCal_EvUpdate=sanitize_text_field($_POST['Total_SoftCal_EvUpdate']);
					$wpdb->query($wpdb->prepare("UPDATE $table_name3 set TotalSoftCal_EvName = %s, TotalSoftCal_EvCal = %s, TotalSoftCal_EvStartDate = %s, TotalSoftCal_EvEndDate = %s, TotalSoftCal_EvURL = %s, TotalSoftCal_EvURLNewTab = %s, TotalSoftCal_EvStartTime = %s, TotalSoftCal_EvEndTime = %s, TotalSoftCal_EvColor = %s WHERE id = %d", $TotalSoftCal_EvName, $TotalSoftCal_EvCal, $TotalSoftCal_EvStartDate, $TotalSoftCal_EvEndDate, $TotalSoftCal_EvURL, $TotalSoftCal_EvURLNewTab, $TotalSoftCal_EvStartTime, $TotalSoftCal_EvEndTime, $TotalSoftCal_EvColor, $Total_SoftCal_EvUpdate));
					$wpdb->query($wpdb->prepare("UPDATE $table_name6 set TotalSoftCal_EvDesc = %s, TotalSoftCal_EvImg = %s, TotalSoftCal_EvVid_Src = %s, TotalSoftCal_EvVid_Iframe = %s WHERE TotalSoftCal_EvCal = %s", $TotalSoftCal_EvDesc, $TotalSoftCal_EvImg, $TotalSoftCal_EvVid_Src, $TotalSoftCal_EvVid_Iframe, $Total_SoftCal_EvUpdate));
					$wpdb->query($wpdb->prepare("UPDATE $table_name10 set TotalSoftCal_EvRec = %s WHERE TotalSoftCal_EvCal = %s", $TotalSoftCal_EvRec, $Total_SoftCal_EvUpdate));
				}
			}
		}
		else
		{
			wp_die('Security check fail');
		}
	}

	$TotalSoftCalCount = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id>%d",0));
	$TotalSoftEvCount = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d order by id",0));
?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../CSS/totalsoft.css',__FILE__);?>">
<link href="https://fonts.googleapis.com/css?family=ABeeZee|Abel|Abhaya+Libre|Abril+Fatface|Aclonica|Acme|Actor|Adamina|Advent+Pro|Aguafina+Script|Akronim|Aladin|Aldrich|Alef|Alegreya|Alegreya+SC|Alegreya+Sans|Alegreya+Sans+SC|Alex+Brush|Alfa+Slab+One|Alice|Alike|Alike+Angular|Allan|Allerta|Allerta+Stencil|Allura|Almendra|Almendra+Display|Almendra+SC|Amarante|Amaranth|Amatic+SC|Amethysta|Amiko|Amiri|Amita|Anaheim|Andada|Andika|Angkor|Annie+Use+Your+Telescope|Anonymous+Pro|Antic|Antic+Didone|Antic+Slab|Anton|Arapey|Arbutus|Arbutus+Slab|Architects+Daughter|Archivo|Archivo+Black|Archivo+Narrow|Aref+Ruqaa|Arima+Madurai|Arimo|Arizonia|Armata|Arsenal|Artifika|Arvo|Arya|Asap|Asap+Condensed|Asar|Asset|Assistant|Astloch|Asul|Athiti|Atma|Atomic+Age|Aubrey|Audiowide|Autour+One|Average|Average+Sans|Averia+Gruesa+Libre|Averia+Libre|Averia+Sans+Libre|Averia+Serif+Libre|Bad+Script|Bahiana|Baloo|Baloo+Bhai|Baloo+Bhaijaan|Baloo+Bhaina|Baloo+Chettan|Baloo+Da|Baloo+Paaji|Baloo+Tamma|Baloo+Tammudu|Baloo+Thambi|Balthazar|Bangers|Barlow|Barlow+Condensed|Barlow+Semi+Condensed|Barrio|Basic|Battambang|Baumans|Bayon|Belgrano|Bellefair|Belleza|BenchNine|Bentham|Berkshire+Swash|Bevan|Bigelow+Rules|Bigshot+One|Bilbo|Bilbo+Swash+Caps|BioRhyme|BioRhyme+Expanded|Biryani|Bitter|Black+And+White+Picture|Black+Han+Sans|Black+Ops+One|Bokor|Bonbon|Boogaloo|Bowlby+One|Bowlby+One+SC|Brawler|Bree+Serif|Bubblegum+Sans|Bubbler+One|Buda:300|Buenard|Bungee|Bungee+Hairline|Bungee+Inline|Bungee+Outline|Bungee+Shade|Butcherman|Butterfly+Kids|Cabin|Cabin+Condensed|Cabin+Sketch|Caesar+Dressing|Cagliostro|Cairo|Calligraffitti|Cambay|Cambo|Candal|Cantarell|Cantata+One|Cantora+One|Capriola|Cardo|Carme|Carrois+Gothic|Carrois+Gothic+SC|Carter+One|Catamaran|Caudex|Caveat|Caveat+Brush|Cedarville+Cursive|Ceviche+One|Changa|Changa+One|Chango|Chathura|Chau+Philomene+One|Chela+One|Chelsea+Market|Chenla|Cherry+Cream+Soda|Cherry+Swash|Chewy|Chicle|Chivo|Chonburi|Cinzel|Cinzel+Decorative|Clicker+Script|Coda|Coda+Caption:800|Codystar|Coiny|Combo|Comfortaa|Coming+Soon|Concert+One|Condiment|Content|Contrail+One|Convergence|Cookie|Copse|Corben|Cormorant|Cormorant+Garamond|Cormorant+Infant|Cormorant+SC|Cormorant+Unicase|Cormorant+Upright|Courgette|Cousine|Coustard|Covered+By+Your+Grace|Crafty+Girls|Creepster|Crete+Round|Crimson+Text|Croissant+One|Crushed|Cuprum|Cute+Font|Cutive|Cutive+Mono|Damion|Dancing+Script|Dangrek|David+Libre|Dawning+of+a+New+Day|Days+One|Dekko|Delius|Delius+Swash+Caps|Delius+Unicase|Della+Respira|Denk+One|Devonshire|Dhurjati|Didact+Gothic|Diplomata|Diplomata+SC|Do+Hyeon|Dokdo|Domine|Donegal+One|Doppio+One|Dorsa|Dosis|Dr+Sugiyama|Duru+Sans|Dynalight|EB+Garamond|Eagle+Lake|East+Sea+Dokdo|Eater|Economica|Eczar|El+Messiri|Electrolize|Elsie|Elsie+Swash+Caps|Emblema+One|Emilys+Candy|Encode+Sans|Encode+Sans+Condensed|Encode+Sans+Expanded|Encode+Sans+Semi+Condensed|Encode+Sans+Semi+Expanded|Engagement|Englebert|Enriqueta|Erica+One|Esteban|Euphoria+Script|Ewert|Exo|Exo+2|Expletus+Sans|Fanwood+Text|Farsan|Fascinate|Fascinate+Inline|Faster+One|Fasthand|Fauna+One|Faustina|Federant|Federo|Felipa|Fenix|Finger+Paint|Fira+Mono|Fira+Sans|Fira+Sans+Condensed|Fira+Sans+Extra+Condensed|Fjalla+One|Fjord+One|Flamenco|Flavors|Fondamento|Fontdiner+Swanky|Forum|Francois+One|Frank+Ruhl+Libre|Freckle+Face|Fredericka+the+Great|Fredoka+One|Freehand|Fresca|Frijole|Fruktur|Fugaz+One|GFS+Didot|GFS+Neohellenic|Gabriela|Gaegu|Gafata|Galada|Galdeano|Galindo|Gamja+Flower|Gentium+Basic|Gentium+Book+Basic|Geo|Geostar|Geostar+Fill|Germania+One|Gidugu|Gilda+Display|Give+You+Glory|Glass+Antiqua|Glegoo|Gloria+Hallelujah|Goblin+One|Gochi+Hand|Gorditas|Gothic+A1|Goudy+Bookletter+1911|Graduate|Grand+Hotel|Gravitas+One|Great+Vibes|Griffy|Gruppo|Gudea|Gugi|Gurajada|Habibi|Halant|Hammersmith+One|Hanalei|Hanalei+Fill|Handlee|Hanuman|Happy+Monkey|Harmattan|Headland+One|Heebo|Henny+Penny|Herr+Von+Muellerhoff|Hi+Melody|Hind|Hind+Guntur|Hind+Madurai|Hind+Siliguri|Hind+Vadodara|Holtwood+One+SC|Homemade+Apple|Homenaje|IBM+Plex+Mono|IBM+Plex+Sans|IBM+Plex+Sans+Condensed|IBM+Plex+Serif|IM+Fell+DW+Pica|IM+Fell+DW+Pica+SC|IM+Fell+Double+Pica|IM+Fell+Double+Pica+SC|IM+Fell+English|IM+Fell+English+SC|IM+Fell+French+Canon|IM+Fell+French+Canon+SC|IM+Fell+Great+Primer|IM+Fell+Great+Primer+SC|Iceberg|Iceland|Imprima|Inconsolata|Inder|Indie+Flower|Inika|Inknut+Antiqua|Irish+Grover|Istok+Web|Italiana|Italianno|Itim|Jacques+Francois|Jacques+Francois+Shadow|Jaldi|Jim+Nightshade|Jockey+One|Jolly+Lodger|Jomhuria|Josefin+Sans|Josefin+Slab|Joti+One|Jua|Judson|Julee|Julius+Sans+One|Junge|Jura|Just+Another+Hand|Just+Me+Again+Down+Here|Kadwa|Kalam|Kameron|Kanit|Kantumruy|Karla|Karma|Katibeh|Kaushan+Script|Kavivanar|Kavoon|Kdam+Thmor|Keania+One|Kelly+Slab|Kenia|Khand|Khmer|Khula|Kirang+Haerang|Kite+One|Knewave|Kotta+One|Koulen|Kranky|Kreon|Kristi|Krona+One|Kurale|La+Belle+Aurore|Laila|Lakki+Reddy|Lalezar|Lancelot|Lateef|Lato|League+Script|Leckerli+One|Ledger|Lekton|Lemon|Lemonada|Libre+Barcode+128|Libre+Barcode+128+Text|Libre+Barcode+39|Libre+Barcode+39+Extended|Libre+Barcode+39+Extended+Text|Libre+Barcode+39+Text|Libre+Baskerville|Libre+Franklin|Life+Savers|Lilita+One|Lily+Script+One|Limelight|Linden+Hill|Lobster|Lobster+Two|Londrina+Outline|Londrina+Shadow|Londrina+Sketch|Londrina+Solid|Lora|Love+Ya+Like+A+Sister|Loved+by+the+King|Lovers+Quarrel|Luckiest+Guy|Lusitana|Lustria|Macondo|Macondo+Swash+Caps|Mada|Magra|Maiden+Orange|Maitree|Mako|Mallanna|Mandali|Manuale|Marcellus|Marcellus+SC|Marck+Script|Margarine|Marko+One|Marmelad|Martel|Martel+Sans|Marvel|Mate|Mate+SC|Maven+Pro|McLaren|Meddon|MedievalSharp|Medula+One|Meera+Inimai|Megrim|Meie+Script|Merienda|Merienda+One|Merriweather|Merriweather+Sans|Metal|Metal+Mania|Metamorphous|Metrophobic|Michroma|Milonga|Miltonian|Miltonian+Tattoo|Mina|Miniver|Miriam+Libre|Mirza|Miss+Fajardose|Mitr|Modak|Modern+Antiqua|Mogra|Molengo|Molle:400i|Monda|Monofett|Monoton|Monsieur+La+Doulaise|Montaga|Montez|Montserrat|Montserrat+Alternates|Montserrat+Subrayada|Moul|Moulpali|Mountains+of+Christmas|Mouse+Memoirs|Mr+Bedfort|Mr+Dafoe|Mr+De+Haviland|Mrs+Saint+Delafield|Mrs+Sheppards|Mukta|Mukta+Mahee|Mukta+Malar|Mukta+Vaani|Muli|Mystery+Quest|NTR|Nanum+Brush+Script|Nanum+Gothic|Nanum+Gothic+Coding|Nanum+Myeongjo|Nanum+Pen+Script|Neucha|Neuton|New+Rocker|News+Cycle|Niconne|Nixie+One|Nobile|Nokora|Norican|Nosifer|Nothing+You+Could+Do|Noticia+Text|Noto+Sans|Noto+Serif|Nova+Cut|Nova+Flat|Nova+Mono|Nova+Oval|Nova+Round|Nova+Script|Nova+Slim|Nova+Square|Numans|Nunito|Nunito+Sans|Odor+Mean+Chey|Offside|Old+Standard+TT|Oldenburg|Oleo+Script|Oleo+Script+Swash+Caps|Open+Sans|Open+Sans+Condensed:300|Oranienbaum|Orbitron|Oregano|Orienta|Original+Surfer|Oswald|Over+the+Rainbow|Overlock|Overlock+SC|Overpass|Overpass+Mono|Ovo|Oxygen|Oxygen+Mono|PT+Mono|PT+Sans|PT+Sans+Caption|PT+Sans+Narrow|PT+Serif|PT+Serif+Caption|Pacifico|Padauk|Palanquin|Palanquin+Dark|Pangolin|Paprika|Parisienne|Passero+One|Passion+One|Pathway+Gothic+One|Patrick+Hand|Patrick+Hand+SC|Pattaya|Patua+One|Pavanam|Paytone+One|Peddana|Peralta|Permanent+Marker|Petit+Formal+Script|Petrona|Philosopher|Piedra|Pinyon+Script|Pirata+One|Plaster|Play|Playball|Playfair+Display|Playfair+Display+SC|Podkova|Poiret+One|Poller+One|Poly|Pompiere|Pontano+Sans|Poor+Story|Poppins|Port+Lligat+Sans|Port+Lligat+Slab|Pragati+Narrow|Prata|Preahvihear|Press+Start+2P|Pridi|Princess+Sofia|Prociono|Prompt|Prosto+One|Proza+Libre|Puritan|Purple+Purse|Quando|Quantico|Quattrocento|Quattrocento+Sans|Questrial|Quicksand|Quintessential|Qwigley|Racing+Sans+One|Radley|Rajdhani|Rakkas|Raleway|Raleway+Dots|Ramabhadra|Ramaraja|Rambla|Rammetto+One|Ranchers|Rancho|Ranga|Rasa|Rationale|Ravi+Prakash|Redressed|Reem+Kufi|Reenie+Beanie|Revalia|Rhodium+Libre|Ribeye|Ribeye+Marrow|Righteous|Risque|Roboto|Roboto+Condensed|Roboto+Mono|Roboto+Slab|Rochester|Rock+Salt|Rokkitt|Romanesco|Ropa+Sans|Rosario|Rosarivo|Rouge+Script|Rozha+One|Rubik|Rubik+Mono+One|Ruda|Rufina|Ruge+Boogie|Ruluko|Rum+Raisin|Ruslan+Display|Russo+One|Ruthie|Rye|Sacramento|Sahitya|Sail|Saira|Saira+Condensed|Saira+Extra+Condensed|Saira+Semi+Condensed|Salsa|Sanchez|Sancreek|Sansita|Sarala|Sarina|Sarpanch|Satisfy|Scada|Scheherazade|Schoolbell|Scope+One|Seaweed+Script|Secular+One|Sedgwick+Ave|Sedgwick+Ave+Display|Sevillana|Seymour+One|Shadows+Into+Light|Shadows+Into+Light+Two|Shanti|Share|Share+Tech|Share+Tech+Mono|Shojumaru|Short+Stack|Shrikhand|Siemreap|Sigmar+One|Signika|Signika+Negative|Simonetta|Sintony|Sirin+Stencil|Six+Caps|Skranji|Slabo+13px|Slabo+27px|Slackey|Smokum|Smythe|Sniglet|Snippet|Snowburst+One|Sofadi+One|Sofia|Song+Myung|Sonsie+One|Sorts+Mill+Goudy|Source+Code+Pro|Source+Sans+Pro|Source+Serif+Pro|Space+Mono|Special+Elite|Spectral|Spectral+SC|Spicy+Rice|Spinnaker|Spirax|Squada+One|Sree+Krushnadevaraya|Sriracha|Stalemate|Stalinist+One|Stardos+Stencil|Stint+Ultra+Condensed|Stint+Ultra+Expanded|Stoke|Strait|Stylish|Sue+Ellen+Francisco|Suez+One|Sumana|Sunflower:300|Sunshiney|Supermercado+One|Sura|Suranna|Suravaram|Suwannaphum|Swanky+and+Moo+Moo|Syncopate|Tajawal|Tangerine|Taprom|Tauri|Taviraj|Teko|Telex|Tenali+Ramakrishna|Tenor+Sans|Text+Me+One|The+Girl+Next+Door|Tienne|Tillana|Timmana|Tinos|Titan+One|Titillium+Web|Trade+Winds|Trirong|Trocchi|Trochut|Trykker|Tulpen+One|Ubuntu|Ubuntu+Condensed|Ubuntu+Mono|Ultra|Uncial+Antiqua|Underdog|Unica+One|UnifrakturCook:700|UnifrakturMaguntia|Unkempt|Unlock|Unna|VT323|Vampiro+One|Varela|Varela+Round|Vast+Shadow|Vesper+Libre|Vibur|Vidaloka|Viga|Voces|Volkhov|Vollkorn|Vollkorn+SC|Voltaire|Waiting+for+the+Sunrise|Wallpoet|Walter+Turncoat|Warnes|Wellfleet|Wendy+One|Wire+One|Work+Sans|Yanone+Kaffeesatz|Yantramanav|Yatra+One|Yellowtail|Yeon+Sung|Yeseva+One|Yesteryear|Yrsa|Zeyada|Zilla+Slab|Zilla+Slab+Highlight" rel="stylesheet">

<form method="POST" enctype="multipart/form-data">
	<script src='<?php echo plugins_url('../JS/tinymce.min.js',__FILE__);?>'></script>
	<script src='<?php echo plugins_url('../JS/jquery.tinymce.min.js',__FILE__);?>'></script>
	<?php wp_nonce_field( 'edit-menu_', 'TS_CalEv_Nonce' );?>
	<div class="Total_Soft_Cal_AMD">
		<a href="http://total-soft.pe.hu/calendar-event/" target="_blank" title="Click to Buy">
			<div class="Full_Version"><i class="totalsoft totalsoft-cart-arrow-down"></i><span style="margin-left:5px;">Get The Full Version</span></div>
		</a>
		<div class="Full_Version_Span">
			This is the free version of the plugin.
		</div>
		<div class="Support_Span">
			<a href="https://wordpress.org/support/plugin/calendar-event/" target="_blank" title="Click Here to Ask">
				<i class="totalsoft totalsoft-comments-o"></i><span style="margin-left:5px;">If you have any questions click here to ask it to our support.</span>
			</a>
		</div>
		<div class="Total_Soft_Cal_AMD1"></div>
		<div class="Total_Soft_Cal_AMD2">
			<i class="Total_Soft_Help totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Click for Creating New Event', 'Total-Soft-Calendar' );?>"></i>
			<span class="Total_Soft_Cal_AMD2_But" onclick="Total_Soft_CalEv_AMD2_But1()">
				<?php echo __( 'Create Event', 'Total-Soft-Calendar' );?>
			</span>
			<i class="Total_Soft_Cal_AMD2_But1 Total_Soft_Help totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Click for Reordering Events', 'Total-Soft-Calendar' );?>"></i>
			<button type="submit" class="Total_Soft_Cal_AMD2_But Total_Soft_Cal_AMD2_But1" name="Total_Soft_Cal_OrderEv">
				<?php echo __( 'Save Order', 'Total-Soft-Calendar' );?>
			</button>
			<i class="Total_Soft_Cal_AMD2_But1 Total_Soft_Help totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Click for Reordering Events', 'Total-Soft-Calendar' );?>"></i>
			<span class="Total_Soft_Cal_AMD2_But Total_Soft_Cal_AMD2_But1" onclick="Total_Soft_CalEv_AMD2_But3()">
				<?php echo __( 'Cancel', 'Total-Soft-Calendar' );?>
			</span>
		</div>
		<div class="Total_Soft_Cal_AMD3" onmouseover="Total_Soft_Cal_Desc_1()">
			<i class="Total_Soft_Help totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Click for Canceling', 'Total-Soft-Calendar' );?>"></i>
			<span class="Total_Soft_Cal_AMD2_But" onclick="TotalSoft_Reload()">
				<?php echo __( 'Cancel', 'Total-Soft-Calendar' );?>
			</span>
			<i class="Total_Soft_Cal_Save_Ev Total_Soft_Help totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Click for Saving Settings', 'Total-Soft-Calendar' );?>"></i>
			<button type="submit" class="Total_Soft_Cal_Save_Ev Total_Soft_Cal_AMD2_But" name="Total_Soft_Cal_SaveEv">
				<?php echo __( 'Save', 'Total-Soft-Calendar' );?>
			</button>
			<i class="Total_Soft_Cal_Update_Ev Total_Soft_Help totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Click for Updating Settings', 'Total-Soft-Calendar' );?>"></i>
			<button type="submit" class="Total_Soft_Cal_Update_Ev Total_Soft_Cal_AMD2_But" name="Total_Soft_Cal_UpdateEv">
				<?php echo __( 'Update', 'Total-Soft-Calendar' );?>
			</button>
			<input type="text" style="display:none;" name="Total_SoftCal_EvUpdate" id="Total_SoftCal_EvUpdate">
		</div>
	</div>
	<div class="Total_Soft_Cal_Loading">
		<img src="<?php echo plugins_url('../Images/loading.gif',__FILE__);?>">
	</div>
	<table class="Total_Soft_AMMTable1">
		<tr class="Total_Soft_AMMTableFR">
			<td><?php echo __( 'No', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Event Title', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Calendar Name', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Start Date', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Reorder', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Copy', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Edit', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Delete', 'Total-Soft-Calendar' );?></td>
		</tr>
	</table>
	<table class="Total_Soft_AMOTable1">
		<?php for($i=0;$i<count($TotalSoftEvCount);$i++){
			$TotalSoft_Cal_Name=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id=%d", $TotalSoftEvCount[$i]->TotalSoftCal_EvCal));
			?> 
			<tr id="Total_Soft_AMOTable1_Calendar_tr_<?php echo $TotalSoftEvCount[$i]->id;?>">
				<td><?php echo $i+1;?></td>
				<td><?php echo $TotalSoftEvCount[$i]->TotalSoftCal_EvName;?></td>
				<td><?php echo $TotalSoft_Cal_Name[0]->TotalSoftCal_Name;?></td>
				<td><?php echo $TotalSoftEvCount[$i]->TotalSoftCal_EvStartDate;?></td>
				<td>
					<i title="Move" class="Total_Soft_icon totalsoft totalsoft-arrows" onmouseover="TotalSoftCal_EventSort()"></i>
					<input type="text" style="display: none;" name="TSoft_Cal_Move_ID_<?php echo $i+1;?>" value="<?php echo $TotalSoftEvCount[$i]->id;?>">
				</td>
				<td><i title="Clone" class="Total_Soft_icon totalsoft totalsoft-file-text" onclick="TotalSoftCal_EditCl(<?php echo $TotalSoftEvCount[$i]->id;?>)"></i></td>
				<td><i title="Edit" class="Total_Soft_icon totalsoft totalsoft-pencil" onclick="TotalSoftCal_EditEv(<?php echo $TotalSoftEvCount[$i]->id;?>)"></i></td>
				<td>
					<i title="Delete" class="TSoft_Cal_Ev_Move2 Total_Soft_icon totalsoft totalsoft-trash" onclick="TotalSoftCal_DelEv(<?php echo $TotalSoftEvCount[$i]->id;?>)"></i>
					<span class="Total_Soft_Calendar_Del_Span">
						<i class="Total_Soft_Calendar_Del_Span_Yes totalsoft totalsoft-check" onclick="TotalSoftCal_DelEv_Yes(<?php echo $TotalSoftEvCount[$i]->id;?>)"></i>
						<i class="Total_Soft_Calendar_Del_Span_No totalsoft totalsoft-times" onclick="TotalSoftCal_DelEv_No(<?php echo $TotalSoftEvCount[$i]->id;?>)"></i>
					</span>
				</td>
			</tr>
		<?php }?>
	</table>
	<table class="Total_Soft_AMEvTable" onmouseover="Total_Soft_Cal_Desc_1()">
		<tr class="Total_Soft_Titles">
			<td colspan="4"><?php echo __( 'Event', 'Total-Soft-Calendar' );?></td>
		</tr>
		<tr>
			<td><?php echo __( 'Event Title', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'You can give a name for event.', 'Total-Soft-Calendar' );?>"></i></td>
			<td><input type="text" name="TotalSoftCal_EvName" id="TotalSoftCal_EvName" class="Total_Soft_Select" placeholder=" * <?php echo __( 'Required', 'Total-Soft-Calendar' );?>"></td>
			<td><?php echo __( 'Calendar Name', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose that version of calendar themes, in which you want to see the Events.', 'Total-Soft-Calendar' );?>"></i></td>
			<td>
				<select class="Total_Soft_Select" name="TotalSoftCal_EvCal" id="TotalSoftCal_EvCal">
					<?php for($i=0;$i<count($TotalSoftCalCount);$i++){?>
						<option value="<?php echo $TotalSoftCalCount[$i]->id;?>"><?php echo $TotalSoftCalCount[$i]->TotalSoftCal_Name;?></option>
					<?php }?>
					<option value="" disabled>Crazy Calendar 1 (Pro)</option>
					<option value="" disabled>Crazy Calendar 2 (pro)</option>
					<option value="" disabled>Crazy Calendar 3 (pro)</option>
					<option value="" disabled>Schedule 1 (Pro)</option>
					<option value="" disabled>Schedule 2 (pro)</option>
					<option value="" disabled>Schedule 3 (pro)</option>
					<option value="" disabled>Full Year Calendar 1 (Pro)</option>
					<option value="" disabled>Full Year Calendar 2 (pro)</option>
					<option value="" disabled>Full Year Calendar 3 (pro)</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo __( 'Start Date', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the start of the event.', 'Total-Soft-Calendar' );?>"></i></td>
			<td><input type="date" class="Total_Soft_Select" name="TotalSoftCal_EvStartDate" id="TotalSoftCal_EvStartDate" placeholder="<?php echo __( 'yyyy-mm-dd', 'Total-Soft-Calendar' );?>"></td>
			<td><?php echo __( 'End Date', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the finish time of the event.', 'Total-Soft-Calendar' );?>"></i></td>
			<td><input type="date" class="Total_Soft_Select" name="TotalSoftCal_EvEndDate" id="TotalSoftCal_EvEndDate" placeholder="<?php echo __( 'yyyy-mm-dd', 'Total-Soft-Calendar' );?>"></td>
		</tr>
		<tr>
			<td><?php echo __( 'URL', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set external URL in the calendar, which should be included in the event.', 'Total-Soft-Calendar' );?>"></i></td>
			<td><input type="text" name="TotalSoftCal_EvURL" id="TotalSoftCal_EvURL" class="Total_Soft_Select" placeholder=" * <?php echo __( 'Optional', 'Total-Soft-Calendar' );?>"></td>
			<td><?php echo __( 'Open In New Tab', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose, by clicking on the link should open in new tab or not.', 'Total-Soft-Calendar' );?>"></i></td>
			<td>
				<select class="Total_Soft_Select" name="TotalSoftCal_EvURLNewTab" id="TotalSoftCal_EvURLNewTab">
					<option value="_blank"><?php echo __( 'Open In New Tab', 'Total-Soft-Calendar' );?></option>
					<option value="none"><?php echo __( 'Open In Same Tab', 'Total-Soft-Calendar' );?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo __( 'Start Time', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the event start time.', 'Total-Soft-Calendar' );?>"></i></td>
			<td><input type="time" name="TotalSoftCal_EvStartTime" id="TotalSoftCal_EvStartTime" placeholder="<?php echo __( 'hh:mm', 'Total-Soft-Calendar' );?>"></td>
			<td><?php echo __( 'End Time', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the event end time.', 'Total-Soft-Calendar' );?>"></i></td>
			<td><input type="time" name="TotalSoftCal_EvEndTime" id="TotalSoftCal_EvEndTime" placeholder="<?php echo __( 'hh:mm', 'Total-Soft-Calendar' );?>"></td>
		</tr>
		<tr>
			<td><?php echo __( 'Event Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select that color, which you want to see for your event, which shows in the calendar.', 'Total-Soft-Calendar' );?>"></i></td>
			<td><input type="text" name="TotalSoftCal_EvColor" id="TotalSoftCal_EvColor" class="Total_Soft_Cal_Color" value="#ffffff"></td>
			<td colspan="2"><?php echo __( 'Event Color option is only for Event, TimeLine, Crazy, Schedule and Full Year Types.', 'Total-Soft-Calendar' );?></td>
		</tr>
		<tr>
			<td>
				<div id="wp-content-media-buttons" class="wp-media-buttons" >
					<a href="#" class="button insert-media add_media" style="border:1px solid #009491; color:#009491; background-color:#f4f4f4" data-editor="TotalSoftCalendar_URL_1" title="Add Media" id="TotalSoftCalendar_URL" onclick="TotalSoftCalendar_URL_Clicked()">
						<span class="wp-media-buttons-icon"></span>Add Media
					</a>
				</div>
				<input type="text" style="display:none;" id="TotalSoftCalendar_URL_1">
			</td>
			<td style="position: relative;">
				<input type="text" id="TotalSoftCalendar_URL_Video_1" name="TotalSoftCalendar_URL_Video_1" readonly class="Total_Soft_Select">
				<i class="TS_Cal_Del_Vid totalsoft totalsoft-times" aria-hidden="true" onclick="TS_Cal_Del_Vid_Cl()"></i>
				<input type="text" id="TotalSoftCalendar_URL_Video_2" name="TotalSoftCalendar_URL_Video_2" class="Total_Soft_Select" style="display:none;">
				<input type="text" id="TotalSoftCalendar_URL_Image_2" name="TotalSoftCalendar_URL_Image_2" class="Total_Soft_Select" style="display:none;">
			</td>
			<td><?php echo __( 'Recurring Time', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'You can set a period for event recur.', 'Total-Soft-Calendar' );?>"></i></td>
			<td>
				<select class="Total_Soft_Select" name="" id="TotalSoftCal_EvRec">
					<option value="none">    <?php echo __( 'None', 'Total-Soft-Calendar' );?>    </option>
					<option value="daily">   <?php echo __( 'Daily', 'Total-Soft-Calendar' );?>   </option>
					<option value="weekly">  <?php echo __( 'Weekly', 'Total-Soft-Calendar' );?>  </option>
					<option value="monthly"> <?php echo __( 'Monthly', 'Total-Soft-Calendar' );?> </option>
					<option value="yearly">  <?php echo __( 'Yearly', 'Total-Soft-Calendar' );?>  </option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="4"><?php echo __( 'Event Description', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'You can give a description for event.', 'Total-Soft-Calendar' );?>"></i></td>
		</tr>
		<tr>
			<td colspan="4">
				<textarea id="TotalSoftCal_EvDesc" name="TotalSoftCal_EvDesc"></textarea>
				<input type="text" style="display: none;" id="TotalSoftCal_EvDesc_1" name="TotalSoftCal_EvDesc_1">
			</td>
		</tr>
	</table>
</form>