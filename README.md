# cd-key
There are now three(3) API's

1. GET - fetching All Valid CD KEY's
End Point: /cdkey.php

2. POST - Create New CD KEY
End Point: /cdkey.php
Headers: Application/json
Body: { "cd_key" : 'your_unique_key'}

3. GET - Validated Your CD KEY
End Point: /cdkey.php?key=YOUR_KEY