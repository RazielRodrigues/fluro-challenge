# FLURO CHALLENGE

Implement the code for a supermarket checkout that calculates the total price of
several items.

In a normal supermarket, items are identified by ‘stock keeping units’ or ‘SKUs’. In our
store, we will use individual letters of the alphabet, A, B, C etc, as the SKUs. Our goods
are priced individually. In addition, some items have promotions of any of the
following types:

- Multipriced: buy n of them and which will cost you y. For example, item A
might cost 50 pence individually but this week we have a special offer where
you can buy 3 As for £1.30.
- Buy n get 1 free
- Meal deal: buy different items together and get a special price. For instance,
items D and E might cost 150 and 200 pence each individually but this week
we have a special offer where you can buy one of each for just £3.

This week’s prices are the following:

| **Item** | **Unit Price (in pence)** | **Special Price**           |
|----------|---------------------------|-----------------------------|
| A        | 50                        |                             |
| B        | 75                        | 2 for £1.25                 |
| C        | 25                        | Buy 3, get one free         |
| D        | 150                       | Buy D and E for £3          |
| E        | 200                       | Buy D and E for £3          |

Our checkout accepts items in any order so if we scan a B, then an A, then another B,
we will recognise the two B’s and apply the special promotion of 2 for £1.25.
Extra points: Because the pricing changes frequently, we will need to be able to pass
in a set of pricing rules each time we start handling a checkout transaction.

# TECH STACK

- RAW PHP 8
- FRANKEN PHP + DOCKER
- COMPOSER
- PHP UNIT

# GETTING STARTED

docker compose up -d

https://localhost/

# TESTS

vendor/bin/phpunit CheckoutTest.php