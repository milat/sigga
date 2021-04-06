<?php

namespace App\Services;

use App\Models\Phone;
use App\Models\Address;
use App\Models\Citizen;
use App\Models\Document;

/**
 *  Populates database with fake data
 */
abstract class PopulateService
{
    public static function run($officeId, $userId)
    {
        // self::documents($officeId, $userId);
        self::citizens($officeId, $userId);
    }

    private static function citizens($officeId, $userId)
    {
        for ($i = 1; $i <= 25000; $i++) {
            $citizen = new Citizen();
            $citizen->office_id = $officeId;
            $citizen->user_id = $userId;
            $citizen->name = 'Faker '.$i.' '.strtotime('now');
            $citizen->identity_document = rand(100, 999).'.'.rand(100, 999).'.'.rand(100, 999).'-'.rand(10, 99);
            $citizen->is_active = true;
            $citizen->save();

            $phone = new Phone();
            $phone->owner_type_id = 3;
            $phone->owner_id = $citizen->id;
            $phone->phone_type_id = rand(1, 5);
            $phone->number = '(11) 9'. rand(6000, 9999).' - '.rand(1000, 9999);
            $phone->is_main = true;
            $phone->save();

            $address = new Address();
            $address->owner_type_id = 3;
            $address->owner_id = $citizen->id;
            $address->address = 'Rua Fake';
            $address->address_type_id = rand(1, 2);
            $address->number = ''.rand(1, 9999);
            $address->neighborhood = 'Fake '.$i;
            $address->city = 'Guarulhos';
            $address->state = 'SP';
            $address->save();

            unset($citizen);
            unset($phone);
            unset($address);
        }
    }

    private static function documents($officeId, $userId)
    {
        $amount = [
            1 => 1000,
            2 => 200,
            3 => 300,
            4 => 100,
            5 => 200
        ];

        foreach ($amount as $documentTypeId => $total) {
            for ($i = 0; $i <= $total; $i++) {
                $document = new Document();
                $document->office_id = $officeId;
                $document->user_id = $userId;
                $document->document_type_id = $documentTypeId;
                $document->date = date('Y-m-d');
                $document->code = str_pad($i + 1, 4, "0", STR_PAD_LEFT).'/'.date('Y');
                $document->title = "Fake número ".$document->code;
                $document->file_name = 'fake.pdf';
                $document->file_extension = 'pdf';
                $document->file_path = 'fake/'.strtotime("now").rand(0, 99999).$document->file_name;
                $document->save();
                $ids[] = $document->id;

                $destination = storage_path('app/'.$document->file_path);
                copy('/var/www/sigga/public/fake/default.pdf',$destination);
                unset($document);
            }
        }
    }
}