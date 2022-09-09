import { Controller } from "@hotwired/stimulus";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
import axios from "axios";

export default class extends Controller {
  static values = {
    infoUrl: String,
  };

  async play(event) {
    event.preventDefault();
    try {
      const res = await axios.get(this.infoUrlValue);
      if (!res) throw new Error("No response!");

      const audio = new Audio(res.data.url);
      audio.play();
    } catch (err) {
      console.warn("Error @ song-controls_controller.js");
      console.error(err);
    }
  }
}
