# Customizing

Customizing application functionality is simple.
We recommend to keep a few things in mind:

- altering database layout can be done in `setup.php`
- new actions can be created in `src/Actions/` and need to be registered in `src/index.php`
    - when creating new actions, use the correct namespaces.
- helper functions and objects can be created in `src/Helpers`
    - when creating new helpers, use correct namespaces
    - Helpers should be tested to ensure stability
- examine the exiting functionality to learn about the structure