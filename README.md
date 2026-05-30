# yellow-session
Simple Session Extension for Datenstrom Yellow  

The main purpose of this extension is to use its functions in other extensions.

## Example
``` php
// Using Session Extension in another Extension
if ($this->yellow->extension->isExisting("session")) {

    $this->yellow->extension->get("session")->setSession("Key1", "Value1"); // one liner

    // When multiply time used this approach is suggested:
    $session = $this->yellow->extension->get("session");
    $session->setSession("Key2", "Value2");
    $output = $session->getSession("Key2");
}
```

## Testing

Set a session (example markdown page):  
``` 
---
Title: Example page
---
This is an example page seting a session:
[session set Key1 Value1]
```
Reading a session: 
``` 
[session get Key1]
[session get Key2 "Value2 not set"]  // optional
```

Deleting a session:  
``` 
[session del Key1]
``` 


## Discussion
This is just an inital proposal.  
Please use this discussion to bring in your suggestions:
https://github.com/datenstrom/community/discussions/1083
