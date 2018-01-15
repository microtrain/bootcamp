# TypeScript

## Introduction

TypeScript is a superset of JavaScript that adds strict typing and class decorators as a way to extend functionality to other components in a system. Browsers do not directly interpret TypeScript, rather, TypeScript is transpilied into JavaScript.

Install TypeScript
```sh
sudo npm install -g typescript
```

```sh
vim ~/hello.ts
```


```ts
function msg(who) {
    return "Hello, " + who;
}

let who = "World";

document.body.innerHTML = msg(who);
```

```sh
tsc hello.ts
```

## Additional Resources

* [TypeScript](https://www.typescriptlang.org/)
