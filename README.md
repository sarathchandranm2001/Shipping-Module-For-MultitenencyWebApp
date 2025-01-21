"# Shipping-Module-For-MultitenencyWebApp" 
## Installation Instructions
1. **Install Laravel 9**:
   ```bash
   composer create-project laravel/laravel shipping-module
   ```
2. **Install Multi-Tenancy Package**:
   Use a package like `stancl/tenancy` for multi-tenancy support.
   ```bash
   composer require stancl/tenancy
   ```
3. **Set up database migration for tenants**:
   Run the following command to scaffold tenancy migrations:
   ```bash
   php artisan tenancy:install
   ```

---

## App Structure
### Models
#### Shipping Method
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
        'tenant_id', 'method_name', 'carrier', 'base_rate', 'per_item_rate', 'per_weight_rate', 'minimum_order_value', 'maximum_order_value', 'status'
    ];
}
```

#### Shipping Zone
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'tenant_id', 'zone_name', 'region', 'countries'
    ];
}
```

#### Shipping Rule
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    protected $fillable = [
        'tenant_id', 'zone_id', 'method_id', 'min_weight', 'max_weight', 'min_order_value', 'max_order_value', 'shipping_cost'
    ];
}
```

#### Order Shipment
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderShipment extends Model
{
    protected $fillable = [
        'order_id', 'shipping_method_id', 'carrier', 'tracking_number', 'shipping_cost', 'status', 'shipped_at', 'delivered_at'
    ];
}
```

---

### Migrations
#### Create Shipping Methods Table
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->string('method_name');
            $table->string('carrier');
            $table->decimal('base_rate', 8, 2)->nullable();
            $table->decimal('per_item_rate', 8, 2)->nullable();
            $table->decimal('per_weight_rate', 8, 2)->nullable();
            $table->decimal('minimum_order_value', 8, 2)->nullable();
            $table->decimal('maximum_order_value', 8, 2)->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_methods');
    }
}
```

#### Create Shipping Zones Table
```php
class CreateShippingZonesTable extends Migration
{
    public function up()
    {
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->string('zone_name');
            $table->string('region');
            $table->json('countries');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_zones');
    }
}
```

#### Create Shipping Rules Table
```php
class CreateShippingRulesTable extends Migration
{
    public function up()
    {
        Schema::create('shipping_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->foreignId('zone_id');
            $table->foreignId('method_id');
            $table->decimal('min_weight', 8, 2)->nullable();
            $table->decimal('max_weight', 8, 2)->nullable();
            $table->decimal('min_order_value', 8, 2)->nullable();
            $table->decimal('max_order_value', 8, 2)->nullable();
            $table->decimal('shipping_cost', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_rules');
    }
}
```

---

### Controllers
#### ShippingController
```php
namespace App\Http\Controllers;

use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $shippingMethods = ShippingMethod::where('tenant_id', auth()->user()->tenant_id)->get();
        return view('shipping.index', compact('shippingMethods'));
    }

    public function create()
    {
        return view('shipping.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'method_name' => 'required|string|max:255',
            'carrier' => 'required|string',
        ]);

        ShippingMethod::create(array_merge(
            $request->only('method_name', 'carrier', 'base_rate', 'per_item_rate', 'per_weight_rate', 'minimum_order_value', 'maximum_order_value', 'status'),
            ['tenant_id' => auth()->user()->tenant_id]
        ));

        return redirect()->route('shipping.index')->with('success', 'Shipping method added successfully!');
    }
}
```

---

### Routes
```php
use App\Http\Controllers\ShippingController;

Route::middleware(['auth', 'tenant'])->group(function () {
    Route::resource('shipping', ShippingController::class);
});
