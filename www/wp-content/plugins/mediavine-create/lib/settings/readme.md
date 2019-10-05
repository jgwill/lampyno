## Create/Update MV Setting

**Endpoint**: POST - http://mediavine.site/wp-json/mv-settings/v1/settings

**Description**: Accepts both Single Item and Array of Items and uses an upsert method.

Returns created data in either object or array and will create or update entries


#### Body
```
{
  "data": [
    {
      "attributes": {
        "slug": "test-item",
        "value": "Jordan Cauley",
        "data": {
          "label": "Name",
          "type": "text"
        }
      }
    },
    {
      "attributes": {
        "value": "Chelsea Cauley",
        "slug": "new-item"
      }
    }
  ]
}
```

## Read Settings

**Endpoint**: GET - http://mediavine.site/wp-json/mv-settings/v1/settings

**Description**: Returns 50 Settings, needs some additional effort to paginate or allow more than 50 items


#### Returns
```
{
  "links": {
    "self": "http:\/\/www.sugardishme.site\/wp-json\/mv-settings\/v1\/group\/thing?slug=thing&1=thing",
    "next": "http:\/\/www.sugardishme.site\/wp-json\/mv-settings\/v1\/group\/thing?page=2"
  },
  "data": [
    {
      "type": "setting",
      "id": 2,
      "attributes": {
        "slug": "",
        "value": "",
        "data": "",
        "created": 1523378948,
        "modified": 1523378948,
        "group": "pineapple"
      }
    },
    {
      "type": "setting",
      "id": 1,
      "attributes": {
        "slug": "",
        "value": "",
        "data": "",
        "created": 1523378905,
        "modified": 1523378905,
        "group": "thing"
      }
    }
  ]
}
```

## Read Setting by ID

**Endpoint**: GET - http://mediavine.site/wp-json/mv-settings/v1/settings/2

**Description**: Retrieve item by DB ID


#### Returns
```
{
  data: {
    "type": "setting",
    "id": 2,
    "attributes": {
      "slug": "sample",
      "value": "thing",
      "data": "",
      "created": 1523378948,
      "modified": 1523378948,
      "group": "thing"
    }
  }
}
```
```

## Read by Slug

**Endpoint**: GET - http://mediavine.site/wp-json/mv-settings/v1/settings/slug/sample

**Description**: Retrieve an item by its slug


#### Returns
```
{
  data: {
    "type": "setting",
    "id": 2,
    "attributes": {
      "slug": "sample",
      "value": "thing",
      "data": "",
      "created": 1523378948,
      "modified": 1523378948,
      "group": "thing"
    }
  }
}
```

## Read Setting Group

**Endpoint**: GET - http://mediavine.site/wp-json/mv-settings/v1/group/thing

**Description**: Retrieve Settings in a Group, currently limited to 50 items.

#### Returns
```
{
  "links": {
    "self": "http:\/\/www.sugardishme.site\/wp-json\/mv-settings\/v1\/group\/thing?slug=thing&1=thing",
    "next": "http:\/\/www.sugardishme.site\/wp-json\/mv-settings\/v1\/group\/thing?page=2"
  },
  "data": [
    {
      "type": "setting",
      "id": 2,
      "attributes": {
        "slug": "",
        "value": "",
        "data": "",
        "created": 1523378948,
        "modified": 1523378948,
        "group": "thing"
      }
    },
    {
      "type": "setting",
      "id": 1,
      "attributes": {
        "slug": "",
        "value": "",
        "data": "",
        "created": 1523378905,
        "modified": 1523378905,
        "group": "thing"
      }
    }
  ]
}
```

Added Filter

Example usage:

```
  add_filter('mv_create_settings', function($settings) {

    $settings[] = array(
      'slug' => 'testing-filter',
      'value' => 'did it work?',
    );

    return $settings;
  });
```
