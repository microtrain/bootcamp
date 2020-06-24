# Working with MongoDB

MongoDB is a distributed NoSQL NoSchema document database designed for scalability, high availability, and high performance.

## Install MongoDB

[Install MongoDB on Ubuntu 18.04](https://docs.mongodb.com/manual/tutorial/install-mongodb-on-ubuntu/)

By default, the Ubuntu package manager does not know about the MongoDB repository so you'll need to add it to your system. First, add MongoDB's private key to the package manager. Then, update the repository list. Finally, reload the package database.

```sh
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 2930ADAE8CAF5059EE73BB4B58712A2291FA4AD5

echo "deb [ arch=amd64,arm64 ] https://repo.mongodb.org/apt/ubuntu bionic/mongodb-org/4.2 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-4.2.list

sudo apt-get update
```

Now you can install the latest stable release of MongoDB.

```sh
sudo apt-get install -y mongodb-org
```


## Working with MongoDB

Start MongoDB on demand with the following command.

```sh
sudo systemctl start mongod
```

Force MongoDB to start on boot.

```sh
sudo systemctl enable mongod
```


Access the database by typing ```mongo``` at the command line.

```sh
mongo
```

Create a database called cms.

```sh
use cms
```

Show a list of all databases.

```sh
show databases
```

You will not see your new database listed until you insert at least one document into it. This will create a collection called users.

```sh
db.users.insert({"email":"youremail@example.com","firstname":"YourFirstName","lastname":"YourLastName"})
```

Let's break that last command down.

_db_ this calls the database object.

_insert()_ is a method of the collection object, this inserts a record into a target collection. The JSON string contains the key/value pairs that will be inserted into the document. Documents in MongoDB are JSON strings.

_users_ this is the collection upon which collection methods are called. If a collection does not exist, calling insert against the collection will create the collection.


Now if run you ```sh show databases``` you will see _cms_ in the list. Next, you will want to look up your list of collections.

```sh
show collections
```

Now we will create some new documents in the users collection.

```sh
db.users.insert({"email":"sally@example.com","firstname":"Sally","lastname":"Smith"})
db.users.insert({"email":"bob@example.com","firstname":"Bob","lastname":"Smith"})
```

Now we will return all of the documents in the database by calling the find method (will no arguments) against the users collection of the database.

```sh
db.users.find()
```

We can look up specific documents by building a JSON string.

```sh
db.users.find({"email":"sally@example.com"})
```

RegEx allows you to search partial strings like every user who's last name ends in _th_.

```sh
db.users.find({"lastname":/.*th/})
```

Update a document by calling _update()_ with the update modifier _$set_ against a target collection and passing in the *_id* object. Passing the same JSON string into the save method of a collection would completely replace the document.

Update only, using the update modifier.
```sh
db.users.update({ "_id" : ObjectId(PASTE TARGET ID HERE)}, {$set:{"email":"new@email.com"}})
```

Full document replacement by omitting the update modifier
```sh
db.users.update({ "_id" : ObjectId(PASTE TARGET ID HERE)}, {"email":"new@email.com"})
```

The same JSON string you build for looking up documents can be used for deletion bypassing that string into the remove method of collection.

```sh
db.users.find()
db.users.remove({"email":"bob@example.com"})
db.users.find()
```

Use _drop()_ to remove an entire collection;

```sh
show collections
use cms
db.users.drop()
show collections
```

You can drop the entire database by running _dropDatabase()_ directly against the _db_ object.
```sh
use cms
db.dropDatabase()
```

## [Atlas](https://www.mongodb.com/cloud/atlas)

Atlas is a cloud service that provides paid MongoDB clusters. They offer a free sandbox tier which we will use for this lesson.

1. Create an Atlas Account
2. Choose to create a Free Cluster - Choose Provider & Region
3. Explain the IP Addresses

## Additional Resources

## [Compass](https://www.mongodb.com/products/compass)

Compass is a GUI for MongoDB. Optional install through Ubuntu Software Applilcations 

* [Why You Should Never Use MongoDB](http://www.sarahmei.com/blog/2013/11/11/why-you-should-never-use-mongodb/) - Read the article then dig into the comments.
* [Why you should (sometimes) use MongoDB](http://nicholasjohnson.com/blog/why-you-should-sometimes-use-mongo/) - One of the sanest things I've ever read on MongoDB.
* [Atomic vs Non-Atomic Operations](https://preshing.com/20130618/atomic-vs-non-atomic-operations/) 

[Next: NodeJS with Express](/13-Express/README.md)
