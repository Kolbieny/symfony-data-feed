Feature: Importing an item data to the database by CLI command
  Scenario: Item placed correctly in database
    Given The file with data exists and has a following content:
    """
    <?xml version="1.0" encoding="utf-8"?>
      <catalog>
        <item>
          <entity_id>1</entity_id>
          <CategoryName><![CDATA[Green Mountain Ground Coffee]]></CategoryName>
          <sku>20</sku>
          <name><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag]]></name>
          <description></description>
          <shortdesc><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.]]></shortdesc>
          <price>24.0000</price>
          <link>http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html</link>
          <image>http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg</image>
          <Brand><![CDATA[Green Mountain Coffee]]></Brand>
          <Rating>0</Rating>
          <CaffeineType>Caffeinated</CaffeineType>
          <Count>24</Count>
          <Flavored>No</Flavored>
          <Seasonal>No</Seasonal>
          <Instock>Yes</Instock>
          <Facebook>1</Facebook>
          <IsKCup>0</IsKCup>
        </item>
       </catalog>
    """
    When The CLI command "app:item:import" with argument "test-behat.xml" has been called
    Then The CLI command responds with "Items have been imported successfully"
    And Item of id "1" is saved in database
  Scenario: Item not placed in database because of invalid file content
    Given The file with data exists and has a following content:
    """
    <?xml version="1.0" encoding="utf-8"?>
      <misspelled_catalog>
        <item>
          <entity_id>1</entity_id>
          <CategoryName><![CDATA[Green Mountain Ground Coffee]]></CategoryName>
          <sku>20</sku>
          <name><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag]]></name>
          <description></description>
          <shortdesc><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.]]></shortdesc>
          <price>24.0000</price>
          <link>http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html</link>
          <image>http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg</image>
          <Brand><![CDATA[Green Mountain Coffee]]></Brand>
          <Rating>0</Rating>
          <CaffeineType>Caffeinated</CaffeineType>
          <Count>24</Count>
          <Flavored>No</Flavored>
          <Seasonal>No</Seasonal>
          <Instock>Yes</Instock>
          <Facebook>1</Facebook>
          <IsKCup>0</IsKCup>
        </item>
       </catalog>
    """
    When The CLI command "app:item:import" with argument "test-behat.xml" has been called
    Then The CLI command failed
    And Item of id "1" is not saved in database
  Scenario: Item not placed in database because of invalid file name
    Given The file with data exists and has a following content:
    """
    <?xml version="1.0" encoding="utf-8"?>
      <catalog>
        <item>
          <entity_id>1</entity_id>
          <CategoryName><![CDATA[Green Mountain Ground Coffee]]></CategoryName>
          <sku>20</sku>
          <name><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag]]></name>
          <description></description>
          <shortdesc><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.]]></shortdesc>
          <price>24.0000</price>
          <link>http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html</link>
          <image>http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg</image>
          <Brand><![CDATA[Green Mountain Coffee]]></Brand>
          <Rating>0</Rating>
          <CaffeineType>Caffeinated</CaffeineType>
          <Count>24</Count>
          <Flavored>No</Flavored>
          <Seasonal>No</Seasonal>
          <Instock>Yes</Instock>
          <Facebook>1</Facebook>
          <IsKCup>0</IsKCup>
        </item>
       </catalog>
    """
    When The CLI command "app:item:import" with argument "not-exists.xml" has been called
    Then The CLI command failed
    And Item of id "1" is not saved in database