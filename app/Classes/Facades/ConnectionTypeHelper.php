<?

namespace App\Classes\Facades;

class ConnectionTypeHelper{
    public static function toReadableString($value){
        $data = [
            'new_connection' => 'New Connection',

        ];

        return $data[$value];
    }
}
