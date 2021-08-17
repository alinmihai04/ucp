<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
use DB;

class Vehicle extends Model
{
    protected $table = 'player_vehicles';

	public static $vehColors = array(
		'grey', '#CEB8F6', '#2A77A1', '#840410', '#263739', '#86446E', '#D78E10', '#4C75B7', '#BDBEC6', '#5E7072',
		'#46597A', '#656A79', '#5D7E8D', '#58595A', '#D6DAD6', '#9CA1A3', '#335F3F', '#730E1A', '#7B0A2A', '#9F9D94',
		'#3B4E78', '#732E3E', '#691E3B', '#96918C', '#515459', '#3F3E45', '#A5A9A7', '#635C5A', '#3D4A68', '#979592',
		'#421F21', '#5F272B', '#8494AB', '#767B7C', '#646464', '#5A5752', '#252527', '#2D3A35', '#93A396', '#6D7A88',
		'#221918', '#6F675F', '#7C1C2A', '#5F0A15', '#193826', '#5D1B20', '#9D9872', '#7A7560', '#989586', '#ADB0B0',
		'#848988', '#304F45', '#4D6268', '#162248', '#272F4B', '#7D6256', '#9EA4AB', '#9C8D71', '#6D1822', '#4E6881',
		'#9C9C98', '#917347', '#661C26', '#949D9F', '#A4A7A5', '#8E8C46', '#341A1E', '#6A7A8C', '#AAAD8E', '#AB988F',
		'#851F2E', '#6F8297', '#585853', '#9AA790', '#601A23', '#20202C', '#A4A096', '#AA9D84', '#78222B', '#0E316D',
		'#722A3F', '#7B715E', '#741D28', '#1E2E32', '#4D322F', '#7C1B44', '#2E5B20', '#395A83', '#6D2837', '#A7A28F',
		'#AFB1B1', '#364155', '#6D6C6E', '#0F6A89', '#204B6B', '#2B3E57', '#9B9F9D', '#6C8495', '#4D8495', '#AE9B7F',
		'#406C8F', '#1F253B', '#AB9276', '#134573', '#96816C', '#64686A', '#105082', '#A19983', '#385694', '#525661',
		'#7F6956', '#8C929A', '#596E87', '#473532', '#44624F', '#730A27', '#223457', '#640D1B', '#A3ADC6', '#695853',
		'#9B8B80', '#620B1C', '#5B5D5E', '#624428', '#731827', '#1B376D', '#EC6AAE', '#000000',
		'#177517', '#210606', '#125478', '#452A0D', '#571E1E', '#010701', '#25225A', '#2C89AA', '#8A4DBD', '#35963A',
		'#B7B7B7', '#464C8D', '#84888C', '#817867', '#817A26', '#6A506F', '#583E6F', '#8CB972', '#824F78', '#6D276A',
		'#1E1D13', '#1E1306', '#1F2518', '#2C4531', '#1E4C99', '#2E5F43', '#1E9948', '#1E9999', '#999976', '#7C8499',
		'#992E1E', '#2C1E08', '#142407', '#993E4D', '#1E4C99', '#198181', '#1A292A', '#16616F', '#1B6687', '#6C3F99',
		'#481A0E', '#7A7399', '#746D99', '#53387E', '#222407', '#3E190C', '#46210E', '#991E1E', '#8D4C8D', '#805B80',
		'#7B3E7E', '#3C1737', '#733517', '#781818', '#83341A', '#8E2F1C', '#7E3E53', '#7C6D7C', '#020C02', '#072407',
		'#163012', '#16301B', '#642B4F', '#368452', '#999590', '#818D96', '#99991E', '#7F994C', '#839292', '#788222',
		'#2B3C99', '#3A3A0B', '#8A794E', '#0E1F49', '#15371C', '#15273A', '#375775', '#060820', '#071326', '#20394B',
		'#2C5089', '#15426C', '#103250', '#241663', '#692015', '#8C8D94', '#516013', '#090F02', '#8C573A', '#52888E',
		'#995C52', '#99581E', '#993A63', '#998F4E', '#99311E', '#0D1842', '#521E1E', '#42420D', '#4C991E', '#082A1D',
		'#96821D', '#197F19', '#3B141F', '#745217', '#893F8D', '#7E1A6C', '#0B370B', '#27450D', '#071F24', '#784573',
		'#8A653A', '#732617', '#319490', '#56941D', '#59163D', '#1B8A2F', '#38160B', '#041804', '#355D8E', '#2E3F5B',
		'#561A28', '#4E0E27', '#706C67', '#3B3E42', '#2E2D33', '#7B7E7D', '#4A4442', '#28344E'
	);    

	public static $namevehicles = array(
		400 => "Landstalker", 401 => "Bravura", 402 => "Buffalo", 403 => "Linerunner", 404 => "Perrenial", 405 => "Sentinel", 406 => "Dumper", 407 => "Firetruck",
		408 => "Trashmaster", 409 => "Stretch", 410 => "Manana", 411 => "Infernus", 412 => "Voodoo", 413 => "Pony", 414 => "Mule", 415 => "Cheetah", 
		416 => "Ambulance", 417 => "Leviathan", 418 => "Moonbeam", 419 => "Esperanto", 420 => "Taxi", 421 => "Washington", 422 => "Bobcat", 423 => "Whoopee",
		424 => "BFInjection", 425 => "Hunter", 426 => "Premier", 427 => "Enforcer", 428 => "Securicar", 429 => "Banshee", 430 => "Predator", 431 => "Bus", 
		432 => "Rhino", 433 => "Barracks", 434 => "Hotknife", 435 => "Trailer", 436 => "Previon", 437 => "Coach", 438 => "Cabbie", 439 => "Stallion", 
		440 => "Rumpo", 441 => "RCBandit", 442 => "Romero", 443 => "Packer", 444 => "Monster", 445 => "Admiral", 446 => "Squalo", 447 => "Seasparrow",
		448 => "Pizzaboy", 449 => "Tram", 450 => "Trailer", 451 => "Turismo", 452 => "Speeder", 453 => "Reefer", 454 => "Tropic", 455 => "Flatbed", 456 => "Yankee",
		457 => "Caddy", 458 => "Solair", 459 => "Berkley\'sRCVan", 460 => "Skimmer", 461 => "PCJ-600", 462 => "Faggio", 463 => "Freeway", 464 => "RCBaron", 
		465 => "RCRaider", 466 => "Glendale", 467 => "Oceanic", 468 => "Sanchez", 469 => "Sparrow", 470 => "Patriot", 471 => "Quad", 472 => "Coastguard", 
		473 => "Dinghy", 474 => "Hermes", 475 => "Sabre", 476 => "Rustler", 477 => "ZR-350", 478 => "Walton", 479 => "Regina", 480 => "Comet", 481 => "BMX",
		482 => "Burrito", 483 => "Camper", 484 => "Marquis", 485 => "Baggage", 486 => "Dozer", 487 => "Maverick", 488 => "NewsChopper", 489 => "Rancher",
		490 => "FBIRancher", 491 => "Virgo", 492 => "Greenwood", 493 => "Jetmax", 494 => "Hotring", 495 => "Sandking", 496 => "BlistaCompact", 
		497 => "PoliceMaverick", 498 => "Boxville", 499 => "Benson", 500 => "Mesa", 501 => "RCGoblin", 502 => "HotringRacerA", 503 => "HotringRacerB", 
		504 => "BloodringBanger", 505 => "Rancher", 506 => "SuperGT", 507 => "Elegant", 508 => "Journey", 509 => "Bike", 510 => "MountainBike",	511 => "Beagle",
		512 => "Cropduster", 513 => "Stunt", 514 => "Tanker", 515 => "Roadtrain", 516 => "Nebula", 517 => "Majestic", 518 => "Buccaneer", 519 => "Shamal",
		520 => "Hydra", 521 => "FCR-900", 522 => "NRG-500", 523 => "HPV1000", 524 => "CementTruck", 525 => "TowTruck", 526 => "Fortune", 527 => "Cadrona", 
		528 => "FBITruck",529 => "Willard", 530 => "Forklift", 531 => "Tractor", 532 => "Combine", 533 => "Feltzer", 534 => "Remington", 535 => "Slamvan", 
		536 => "Blade", 537 => "Freight",538 => "Streak", 539 => "Vortex", 540 => "Vincent", 541 => "Bullet", 542 => "Clover", 543 => "Sadler", 544 => "Firetruck",
		545 => "Hustler", 546 => "Intruder", 547 => "Primo", 548 => "Cargobob", 549 => "Tampa", 550 => "Sunrise", 551 => "Merit", 552 => "Utility", 553 => "Nevada",
		554 => "Yosemite", 555 => "Windsor", 556 => "Monster", 557 => "Monster", 558 => "Uranus", 559 => "Jester", 560 => "Sultan", 561 => "Stratium", 
		562 => "Elegy", 563 => "Raindance", 564 => "RCTiger", 565 => "Flash", 566 => "Tahoma", 567 => "Savanna", 568 => "Bandito", 569 => "FreightFlat", 
		570 => "StreakCarriage", 571 => "Kart", 572 => "Mower", 573 => "Dune", 574 => "Sweeper", 575 => "Broadway", 576 => "Tornado", 577 => "AT-400", 
		578 => "DFT-30", 579 => "Huntley", 580 => "Stafford", 581 => "BF-400", 582 => "NewsVan", 583 => "Tug", 584 => "Trailer", 585 => "Emperor", 586 => "Wayfarer",
		587 => "Euros", 588 => "Hotdog", 589 => "Club", 590 => "FreightBox", 591 => "Trailer", 592 => "Andromada", 593 => "Dodo", 594 => "RCCam", 595 => "Launch", 
		596 => "PoliceCar", 597 => "PoliceCar", 598 => "PoliceCar", 599 => "PoliceRanger", 600 => "Picador", 601 => "S.W.A.T", 602 => "Alpha", 603 => "Phoenix",
		604 => "Glendale", 605 => "Sadler", 606 => "Luggage", 607 => "Luggage", 608 => "Stairs", 609 => "Boxville", 610 => "Tiller", 611 => "UtilityTrailer"
	);	

    public static function getPlayerVehicles($user)
    {
    	if(Cache::has('cardata'.$user.''))
    	{
    		$value = Cache::get('cardata'.$user.'');
    	}
    	else
    	{
    		$value = self::where('vehicle_ownerid', '=', $user)->get();

    		Cache::add('cardata'.$user.'', $value, 50);
    	}

    	return $value;
    }
}
