<?php

class ProductFormExtension extends DataExtension
{

    public function updateFields (FieldList $fields)
    {
        $ProductId = $fields->fieldByName('ProductID')->value;
        $product = DataObject::get_by_id('Product', $ProductId);
        
        $variations = $product->Variations();
        
        if ($variations && $variations->exists())
            foreach ($variations as $variation) {
                
                if ($pid = $variation->LinkProductID) {
                    $LinkProduct = Product::get_by_id('Product', $pid);
                    $map[] = array(
                            'price' => $LinkProduct->getUglyPrice(),
                            'options' => $variation->Options()->column('ID'),
                            'LinkProductID' => $variation->LinkProductID,
                            'free' => _t('Product.FREE', 'Free')
                    );
                    $datamap = HiddenField::create('DataMap', 'DataMap', 
                            json_encode($map));
                    $fields->push($datamap);
                }
            }
        $fields->push(
                HiddenField::create('LinkProductID', 'LinkProductID', 
                        $product->ID));
        if (! $product->requiresVariation()) {
            foreach ($fields as $field) {
                if ('Attribute_OptionField' == $field->class) {
                    $fields->removeByName($field->name);
                }
            }
        }
    }

  
}