import BaseClass from "./BaseClass.js";
import ErrorHandler from "./Utility/ErrorHandler.js";
/**
 * Represents the Dashboard class.
 * @extends BaseClass
 */
export default class Dashboard extends BaseClass {
    /**
     * Constructor for the Dashboard class.
     * @param {Object} props - The properties for the class.
     *
     */
    constructor(props = null) {
        super(props);
    }
}
window.service = new Dashboard(props);