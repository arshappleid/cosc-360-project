const startDate = new Date('2024-04-05T17:15:19');
const basePrice = 20;
const fluctuation = 3;
const itemIds = [12]; // Assuming you're still generating for ITEM_ID 2
const storeIds = [1, 2, 3]; // The three store IDs

function formatDate(date) {
  const year = date.getFullYear();
  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const day = date.getDate().toString().padStart(2, '0');
  const hours = date.getHours().toString().padStart(2, '0');
  const minutes = date.getMinutes().toString().padStart(2, '0');
  const seconds = date.getSeconds().toString().padStart(2, '0');
  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

function generateInsertStatements() {
  const statements = [];

  storeIds.forEach((storeId) => {
    itemIds.forEach((itemId) => {
      let currentDate = new Date(startDate);

      for (let i = 0; i < 10; i++) {
        const priceChange = Math.floor(Math.random() * (fluctuation * 2 + 1)) - fluctuation;
        const price = basePrice + priceChange;
        const formattedDate = formatDate(currentDate);

        const statement = `INSERT INTO Item_Price_Entry (STORE_ID, ITEM_ID, Item_Price, Time_Updated) VALUES (${storeId}, ${itemId}, ${price.toFixed(2)}, '${formattedDate}');`;
        statements.push(statement);

        currentDate.setDate(currentDate.getDate() - 1);
      }
    });
  });

  return statements;
}

// Generate and print the INSERT statements
const insertStatements = generateInsertStatements();
console.log(insertStatements.join('\n'));