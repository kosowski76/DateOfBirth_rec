# DateOfBirth_rec
 Task: Write a single class representing the Date of birth (DOB) of an example person.
    - original task description file: 'Tech Test.pdf' in the attachment.
    
  This is a demo script created for recruitment purposes,
 presents the life cycle I use to develop software (app, modules, etc.) using the Test Driven Development technique.

  This is only a demo and is not the final product, it is a sample script for recruitment purposes,
 also need 'Test doubles' to prepare

  
## Technical specification

    Tools used at the development stage: PHP 8.2, PHPUnit 10.5, Xdebug 3.3
    Environment: Linux Debian 10 Buster
    
    I used the Test Driven Development technique to complete the task,
    it is a demonstration of the general life cycle 
    when creating a module (some product, application project)


# 01. Formulation and analysis of the problem.

    - The class allows the user to get the current age in plain text according to the format:
    
         • DOB is less than 17 years old: ‘Young’
         • DOB is between 18 - 60 years old: ‘Adult’
         • DOB is over 60 years old: ‘Senior’
    
        using the $personDOB->getPlainTextAge() function

    - The class should calculate how many specific days of the week (e.g. 'Monday') a person has experienced so far

          $personDOB->countWeekDays('Monday')

    Missed to explain:

     - what timezone?
    
     - how store '$currentDateTime' and how to choose access to $currentDateTime

     - age ranges, 'less than 17 years old' and 'between 18 - 60 years old'
         what with 17 years? 17 is Young or Adult?
        
     - can the '$personDOB->getPlainTextAge()' method be changed to accept parameters,
         it is easier to test.

     - The format of the entered date has not been specified? (YYYY-MM-DD), how should it behave when an incorrect format is entered, an exception is thrown?

     - It is not specified how the class should behave for the entered future date
     
     
# 02. Design and preparation of test support - preparing method names for tests, etc.     
     
    Test:
         project_path/tests/Unit/Src/Domain/DataOfBirthMechanicsTest.php

     directories:
         project_path/app/Domain/DateOfBirth/DateOfBirth.php

     handling labels using Enum:
    
     sending date to method: $personDOB->getPlainTextAge(MM-DD-YYYY),
     the getPlainTextAge(MM-DD-YYYY) method sends time intervals to the ageCalc() converter method to set the age level 'Age': Young, Adult, Senior

     test for method

     a function that converts the number of days from a given date, taking into account leap years
    
     calculation of specific days

         - when the given day falls on 'dateOfBirth'

         - when the given day does not fall in 'dateOfBirth'

    Results of tests: 

         ---
        Testing started at 10:28 ...
        PHPUnit 10.5.3 by Sebastian Bergmann and contributors.
        
        Runtime:       PHP 8.2.14
        Configuration: /var/www/app/phpunit.xml
        
        Time: 00:00.471, Memory: 24.00 MB
        
        OK (20 tests, 20 assertions)
        
        Process finished with exit code 0      
         ---  
      
# 03. Refactor and improving code quality.
     
