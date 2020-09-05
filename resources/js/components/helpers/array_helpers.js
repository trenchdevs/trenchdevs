export const moveToPosition = (arr, index, places) => {

    const items = [...arr];
    const newIndex = index + places;
    const temp = items[newIndex] || null;
    const currentVal = items[index] || null;

    if (temp !== null && currentVal !== null) {
        items[newIndex] = currentVal;
        items[index] = temp;
    }

    return items;

};

export default {
    moveToPosition,
};
